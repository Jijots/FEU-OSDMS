import cv2
import numpy as np
import sys
import json
import argparse
import os

# --- HELPER: Proportional Resize ---
def resize_to_max_dim(image, max_dim=1024):
    """Resizes image keeping aspect ratio. No black borders."""
    h, w = image.shape[:2]
    if max(h, w) <= max_dim:
        return image
    scale = max_dim / float(max(h, w))
    nw, nh = int(w * scale), int(h * scale)
    return cv2.resize(image, (nw, nh), interpolation=cv2.INTER_AREA)

def generate_error(msg):
    print(json.dumps({"confidence_score": 0, "visual_score": 0, "breakdown": msg}))
    sys.exit(0)

def calculate_similarity(img1_path, img2_path, is_stock):
    try:
        if not os.path.exists(img1_path) or not os.path.exists(img2_path):
            generate_error("System error: The requested image file could not be found.")

        img1_src = cv2.imread(img1_path)
        img2_src = cv2.imread(img2_path)

        if img1_src is None or img2_src is None:
            generate_error("System error: Could not read the image formats.")

        img1 = resize_to_max_dim(img1_src)
        img2 = resize_to_max_dim(img2_src)

        mask1 = np.ones(img1.shape[:2], dtype=np.uint8) * 255
        mask2 = np.ones(img2.shape[:2], dtype=np.uint8) * 255

        # --- UNIVERSAL COLOR CHECK ---
        h1 = cv2.calcHist([img1], [0, 1, 2], mask1, [8, 8, 8], [0, 256, 0, 256, 0, 256])
        h2 = cv2.calcHist([img2], [0, 1, 2], mask2, [8, 8, 8], [0, 256, 0, 256, 0, 256])
        color_sim = cv2.compareHist(cv2.normalize(h1, h1), cv2.normalize(h2, h2), cv2.HISTCMP_CORREL)
        color_score = max(0, color_sim) * 100

        gray1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
        gray2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)

        if is_stock:
            clahe = cv2.createCLAHE(clipLimit=6.0, tileGridSize=(8,8))
            sift = cv2.SIFT_create(nfeatures=10000, contrastThreshold=0.02)
        else:
            clahe = cv2.createCLAHE(clipLimit=4.0, tileGridSize=(8,8))
            sift = cv2.SIFT_create(nfeatures=10000)

        kp1, des1 = sift.detectAndCompute(clahe.apply(gray1), mask1)
        kp2, des2 = sift.detectAndCompute(clahe.apply(gray2), mask2)

        flann = cv2.FlannBasedMatcher(dict(algorithm=1, trees=5), dict(checks=100))

        if des1 is not None and des2 is not None and len(des1) > 0 and len(des2) > 0:
            matches = flann.knnMatch(des1, des2, k=2)
            good = []
            for m_n in matches:
                if len(m_n) == 2:
                    m, n = m_n
                    # RRL STRICT 0.75 RATIO ENFORCED
                    if m.distance < 0.75 * n.distance:
                        good.append(m)

            if len(good) >= 5:
                src_pts = np.float32([kp1[m.queryIdx].pt for m in good]).reshape(-1, 1, 2)
                dst_pts = np.float32([kp2[m.trainIdx].pt for m in good]).reshape(-1, 1, 2)

                M, mask_geo = cv2.findHomography(src_pts, dst_pts, cv2.RANSAC, 10.0)

                if mask_geo is not None:
                    inliers = int(np.sum(mask_geo))
                    inlier_ratio = inliers / len(good)

                    if is_stock:
                        struct_val = min(100, (inliers / 10) * 100)
                        raw_score = (color_score * 0.3) + (struct_val * 0.7)
                        final_score = min(98, max(76, raw_score + 25)) if inliers >= 4 else min(45, raw_score)
                        msg = "High match found comparing the item to a stock photo."
                    else:
                        if inliers >= 12:
                            struct_score = min(100, 85 + (inlier_ratio * 15))
                        elif inliers >= 6:
                            struct_score = min(84, 75 + (inlier_ratio * 10))
                        else:
                            struct_score = min(60, inlier_ratio * 150)

                        if struct_score >= 75:
                            final_score = max(struct_score, (struct_score * 0.8) + (color_score * 0.2))
                            msg = "Strong match confirmed based on the object's physical shape and colors."
                        else:
                            final_score = (struct_score * 0.5) + (color_score * 0.5)
                            msg = "Partial match found based on similarities in shape and color."

                        final_score = min(98, max(0, final_score))
                else:
                    final_score = max(15, color_score * 0.5)
                    msg = "Could not confirm physical shape; similarity is based on colors only."
            else:
                final_score = max(10, color_score * 0.4)
                msg = "Not enough clear details. Similarity is based on general colors."
        else:
            final_score = 5
            msg = "Could not identify any matching features between the images."

        # Simplify output label for the UI
        print(json.dumps({
            "confidence_score": int(final_score),
            "visual_score": int(final_score),
            "breakdown": f"Analysis Complete: {msg}"
        }))

    except Exception as e:
        generate_error(f"Analysis failed to run: {str(e)}")

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("img1")
    parser.add_argument("img2")
    parser.add_argument("--stock", action="store_true")

    try:
        args = parser.parse_args()
        calculate_similarity(args.img1, args.img2, args.stock)
    except SystemExit:
        pass
    except Exception as e:
        generate_error(f"System Error: {str(e)}")
