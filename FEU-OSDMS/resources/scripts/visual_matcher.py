import cv2
import numpy as np
import sys
import json
import argparse
import os

# --- NEW HELPER FUNCTION: Letterboxing ---
def resize_with_padding(image, target_size=1024):
    """Resizes image to fit within target_size square without stretching."""
    h, w = image.shape[:2]
    # Calculate scale to fit within the box
    scale = min(target_size / w, target_size / h)
    nw, nh = int(w * scale), int(h * scale)

    # Resize preserving aspect ratio
    resized_image = cv2.resize(image, (nw, nh), interpolation=cv2.INTER_AREA)

    # Create black canvas
    new_image = np.zeros((target_size, target_size, 3), dtype=np.uint8)

    # Center the image
    top = (target_size - nh) // 2
    left = (target_size - nw) // 2
    new_image[top:top+nh, left:left+nw] = resized_image

    return new_image
# -----------------------------------------

def generate_error(msg):
    print(json.dumps({"confidence_score": 0, "visual_score": 0, "breakdown": msg}))
    sys.exit(0)

def calculate_similarity(img1_path, img2_path, is_stock):
    try:
        if not os.path.exists(img1_path) or not os.path.exists(img2_path):
            generate_error("File path does not exist on the server.")

        img1_src = cv2.imread(img1_path)
        img2_src = cv2.imread(img2_path)

        if img1_src is None or img2_src is None:
            generate_error("OpenCV could not decode the image files.")

        # --- THE FIX: USE PADDING INSTEAD OF STRETCHING ---
        img1 = resize_with_padding(img1_src)
        img2 = resize_with_padding(img2_src)
        # --------------------------------------------------

        # Use full image mask (no center circle blindspot)
        mask = np.ones(img1.shape[:2], dtype=np.uint8) * 255

        if is_stock:
            # --- PATHWAY A: STOCK ALGORITHM (Unchanged) ---
            h1 = cv2.calcHist([img1], [0, 1, 2], mask, [8, 8, 8], [0, 256, 0, 256, 0, 256])
            h2 = cv2.calcHist([img2], [0, 1, 2], mask, [8, 8, 8], [0, 256, 0, 256, 0, 256])
            color_sim = cv2.compareHist(cv2.normalize(h1, h1), cv2.normalize(h2, h2), cv2.HISTCMP_CORREL)

            gray1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
            gray2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)
            clahe = cv2.createCLAHE(clipLimit=6.0, tileGridSize=(8,8))

            sift = cv2.SIFT_create(nfeatures=5000, contrastThreshold=0.02)
            kp1, des1 = sift.detectAndCompute(clahe.apply(gray1), mask)
            kp2, des2 = sift.detectAndCompute(clahe.apply(gray2), mask)

            flann = cv2.FlannBasedMatcher(dict(algorithm=1, trees=5), dict(checks=100))

            if des1 is not None and des2 is not None and len(des1) > 0 and len(des2) > 0:
                matches = flann.knnMatch(des1, des2, k=2)
                good = []
                for m_n in matches:
                    if len(m_n) == 2:
                        m, n = m_n
                        if m.distance < 0.85 * n.distance:
                            good.append(m)

                if len(good) > 5:
                    src_pts = np.float32([kp1[m.queryIdx].pt for m in good]).reshape(-1, 1, 2)
                    dst_pts = np.float32([kp2[m.trainIdx].pt for m in good]).reshape(-1, 1, 2)
                    M, mask_geo = cv2.findHomography(src_pts, dst_pts, cv2.RANSAC, 6.0)

                    if mask_geo is not None:
                        inliers = int(np.sum(mask_geo))
                        color_val = max(0, color_sim) * 100
                        struct_val = min(100, (inliers / 10) * 100)
                        raw_score = (color_val * 0.3) + (struct_val * 0.7)

                        if inliers >= 4:
                            final_score = min(98, max(76, raw_score + 25))
                            msg = f"Stock Verified: {inliers} structural points + core color match."
                        else:
                            final_score = min(45, raw_score)
                            msg = f"Weak alignment: Only {inliers} structural points."
                    else:
                        final_score = max(5, color_sim * 40)
                        msg = "No geometric structure found. Relied on color."
                else:
                    final_score = max(5, color_sim * 40)
                    msg = "Insufficient cross-domain features. Relied on color."
            else:
                final_score = 5
                msg = "Feature extraction failed (Stock)."

        else:
            # --- PATHWAY B: STANDARD REAL PHOTO (Unchanged thresholds) ---
            gray1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
            gray2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)
            clahe = cv2.createCLAHE(clipLimit=5.0, tileGridSize=(8,8))

            sift = cv2.SIFT_create(nfeatures=5000)
            kp1, des1 = sift.detectAndCompute(clahe.apply(gray1), mask)
            kp2, des2 = sift.detectAndCompute(clahe.apply(gray2), mask)

            flann = cv2.FlannBasedMatcher(dict(algorithm=1, trees=5), dict(checks=100))

            if des1 is not None and des2 is not None and len(des1) > 0 and len(des2) > 0:
                matches = flann.knnMatch(des1, des2, k=2)
                good = []
                for m_n in matches:
                    if len(m_n) == 2:
                        m, n = m_n
                        if m.distance < 0.75 * n.distance:
                            good.append(m)

                if len(good) > 10:
                    src_pts = np.float32([kp1[m.queryIdx].pt for m in good]).reshape(-1, 1, 2)
                    dst_pts = np.float32([kp2[m.trainIdx].pt for m in good]).reshape(-1, 1, 2)
                    M, mask_geo = cv2.findHomography(src_pts, dst_pts, cv2.RANSAC, 5.0)

                    if mask_geo is not None:
                        inliers = int(np.sum(mask_geo))
                        inlier_ratio = inliers / len(good)

                        if inliers > 25:
                            final_score = min(98, 75 + (inlier_ratio * 30))
                        elif inliers > 10:
                            final_score = min(84, 60 + (inlier_ratio * 40))
                        else:
                            final_score = min(45, inlier_ratio * 150)
                        msg = f"SIFT Verified: {inliers} structural points match."
                    else:
                        final_score = 10
                        msg = "Structural mismatch."
                else:
                    final_score = 5
                    msg = "Insufficient features."
            else:
                final_score = 5
                msg = "Feature extraction failed (Real)."

        print(json.dumps({"confidence_score": int(final_score), "visual_score": int(final_score), "breakdown": msg}))

    except Exception as e:
        generate_error(f"Python Crash: {str(e)}")

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
        generate_error(f"Argument Parsing Error: {str(e)}")
