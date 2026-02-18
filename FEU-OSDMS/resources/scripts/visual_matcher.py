import sys
import json
import traceback

try:
    import cv2
    import numpy as np
except ImportError:
    print(json.dumps({"error": "OpenCV package not installed."}))
    sys.exit(1)

def get_color_score(img1, img2, mask1, mask2):

    #Compares the color of two images using HSV Histograms, ignoring the background (using masks).

    try:
        # Convert to HSV color space
        hsv1 = cv2.cvtColor(img1, cv2.COLOR_BGR2HSV)
        hsv2 = cv2.cvtColor(img2, cv2.COLOR_BGR2HSV)

        # Calculate Histograms (Hue and Saturation only, ignore Brightness/Value)
        # [0, 1] = Channels (Hue, Saturation)
        # [50, 60] = Bins (Granularity of color)
        # [0, 180, 0, 256] = Ranges
        hist1 = cv2.calcHist([hsv1], [0, 1], mask1, [50, 60], [0, 180, 0, 256])
        hist2 = cv2.calcHist([hsv2], [0, 1], mask2, [50, 60], [0, 180, 0, 256])

        # Normalize (scale to 0-1)
        cv2.normalize(hist1, hist1, 0, 1, cv2.NORM_MINMAX)
        cv2.normalize(hist2, hist2, 0, 1, cv2.NORM_MINMAX)

        # Compare using Bhattacharyya distance
        score = cv2.compareHist(hist1, hist2, cv2.HISTCMP_BHATTACHARYYA)
        
        # Bhattacharyya gives 0 for match, 1 for mismatch. We flip it.
        return 1.0 - score
    except:
        return 0.0

def get_shape_score(img1, img2):
    # Compares the shape/texture using ORB features.
    try:
        orb = cv2.ORB_create(nfeatures=1000)
        kp1, des1 = orb.detectAndCompute(img1, None)
        kp2, des2 = orb.detectAndCompute(img2, None)

        if des1 is None or des2 is None: return 0.0

        bf = cv2.BFMatcher(cv2.NORM_HAMMING, crossCheck=False)
        matches = bf.knnMatch(des1, des2, k=2)

        good_matches = []
        for m, n in matches:
            if m.distance < 0.75 * n.distance:
                good_matches.append(m)

        # 40 good matches = 100% shape match
        return min(len(good_matches) / 40.0, 1.0)
    except:
        return 0.0

def compare_images(path1, path2):
    try:
        # Load images
        img1 = cv2.imread(path1)
        img2 = cv2.imread(path2)
        
        # 1. Resize for speed
        img1 = cv2.resize(img1, (500, 500))
        img2 = cv2.resize(img2, (500, 500))

        # 2. Generate Masks (Simple center-box assumption for now since user cropped)
        # In a perfect world we use GrabCut here, but for speed/robustness
        # on user-cropped images, we can often skip complex segmentation
        # or use a simple threshold if needed.
        # For this hybrid demo, we assume the user crop is good and use full image for histogram.
        mask1 = None
        mask2 = None

        # 3. Get Scores
        color_score = get_color_score(img1, img2, mask1, mask2)
        shape_score = get_shape_score(img1, img2)

        # 4. Weighted Average
        # We give Shape slightly more weight (60%) because lighting ruins color often
        final_score = (shape_score * 0.6) + (color_score * 0.4)

        return {
            "visual_similarity": final_score,
            "breakdown": f"Shape: {int(shape_score*100)}% | Color: {int(color_score*100)}%",
            "error": None
        }

    except Exception as e:
        return {"visual_similarity": 0, "error": str(e)}

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Invalid args"}))
        sys.exit(1)
    print(json.dumps(compare_images(sys.argv[1], sys.argv[2])))