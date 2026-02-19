import sys
import json
import traceback

try:
    import cv2
    import numpy as np
except ImportError:
    print(json.dumps({"error": "OpenCV package not installed."}))
    sys.exit(1)

def resize_keep_aspect(image, max_size=500):
    # Resizes the image so the longest side is max_size, keeping aspect ratio intact.
    h, w = image.shape[:2]
    if max(h, w) > max_size:
        scale = max_size / float(max(h, w))
        return cv2.resize(image, (int(w * scale), int(h * scale)), interpolation=cv2.INTER_AREA)
    return image

def get_color_score(img1, img2):
    try:
        hsv1 = cv2.cvtColor(img1, cv2.COLOR_BGR2HSV)
        hsv2 = cv2.cvtColor(img2, cv2.COLOR_BGR2HSV)

        # Calculate Histograms (Hue and Saturation)
        hist1 = cv2.calcHist([hsv1], [0, 1], None, [50, 60], [0, 180, 0, 256])
        hist2 = cv2.calcHist([hsv2], [0, 1], None, [50, 60], [0, 180, 0, 256])

        cv2.normalize(hist1, hist1, 0, 1, cv2.NORM_MINMAX)
        cv2.normalize(hist2, hist2, 0, 1, cv2.NORM_MINMAX)

        score = cv2.compareHist(hist1, hist2, cv2.HISTCMP_BHATTACHARYYA)

        # Bhattacharyya gives 0 for perfect match, 1 for mismatch. We flip it for a % score.
        return max(0.0, 1.0 - score)
    except:
        return 0.0

def get_shape_score(img1, img2):
    try:
        # 2000 features for higher detail recognition
        orb = cv2.ORB_create(nfeatures=2000)
        kp1, des1 = orb.detectAndCompute(img1, None)
        kp2, des2 = orb.detectAndCompute(img2, None)

        if des1 is None or des2 is None: return 0.0

        # FLANN parameters for faster, more accurate matching
        FLANN_INDEX_LSH = 6
        index_params = dict(algorithm=FLANN_INDEX_LSH, table_number=6, key_size=12, multi_probe_level=1)
        search_params = dict(checks=50)

        flann = cv2.FlannBasedMatcher(index_params, search_params)
        matches = flann.knnMatch(des1, des2, k=2)

        good_matches = []
        for match_pair in matches:
            if len(match_pair) == 2:
                m, n = match_pair
                # Lowe's ratio test to filter out false positives
                if m.distance < 0.75 * n.distance:
                    good_matches.append(m)

        # 50 good matches is an excellent threshold for a strong ORB similarity
        score = min(len(good_matches) / 50.0, 1.0)
        return score
    except Exception as e:
        return 0.0

def compare_images(path1, path2):
    try:
        img1 = cv2.imread(path1)
        img2 = cv2.imread(path2)

        if img1 is None or img2 is None:
            return {"visual_similarity": 0, "error": "Could not read images."}

        # 1. Resize properly without squishing
        img1 = resize_keep_aspect(img1, 500)
        img2 = resize_keep_aspect(img2, 500)

        # 2. Get Scores
        color_score = get_color_score(img1, img2)
        shape_score = get_shape_score(img1, img2)

        # 3. Weighted Average (70% Shape / 30% Color)
        final_score = (shape_score * 0.7) + (color_score * 0.3)

        return {
            "visual_similarity": round(final_score, 4),
            "breakdown": f"Shape: {int(shape_score*100)}% | Color: {int(color_score*100)}%",
            "error": None
        }

    except Exception as e:
        return {"visual_similarity": 0, "error": str(e)}

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Invalid args"}))
        sys.exit(1)

    try:
        result = compare_images(sys.argv[1], sys.argv[2])
        print(json.dumps(result))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
