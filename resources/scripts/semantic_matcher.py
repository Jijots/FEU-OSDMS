import sys
import os
import json
import warnings
import difflib # Built-in Python library for Semantic Fuzzy Matching

# Suppress warnings
warnings.filterwarnings("ignore", category=FutureWarning)

# Environment Overrides
os.environ['HOME'] = r'C:\Users\Joss'
os.environ['USERPROFILE'] = r'C:\Users\Joss'

# Library Paths
lib_path = r"C:\Users\Joss\AppData\Local\Packages\PythonSoftwareFoundation.Python.3.11_qbz5n2kfra8p0\LocalCache\local-packages\Python311\site-packages"
if lib_path not in sys.path:
    sys.path.append(lib_path)

def generate_output(match_id, score, msg):
    """The Anti-Crash Output: Always exits with 0 so Laravel can read the error."""
    sys.stdout.flush()
    print(json.dumps({
        "matched_student_id": match_id if score >= 65 else None, # Lowered passing threshold for OCR inaccuracy
        "confidence_score": int(score),
        "visual_score": int(score),
        "breakdown": msg
    }))
    sys.exit(0)

# --- SAFE IMPORTS (STRICTLY OFFLINE) ---
try:
    import PIL.Image
    import pytesseract
    # Configure Tesseract Path
    pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'
except ImportError as e:
    generate_output(None, 0, f"Critical Library Missing: {str(e)}. Please install via pip.")

def semantic_similarity(ocr_text, target_string):
    """Calculates Levenshtein Distance similarity (0.0 to 1.0)"""
    if not ocr_text or not target_string:
        return 0.0
    t1 = str(ocr_text).upper().replace(" ", "")
    t2 = str(target_string).upper().replace(" ", "")
    return difflib.SequenceMatcher(None, t1, t2).ratio()

if __name__ == "__main__":
    try:
        # Args mapping
        name_in = sys.argv[1] if len(sys.argv) > 1 else ""
        id_in = sys.argv[2] if len(sys.argv) > 2 else ""
        prog_in = sys.argv[3] if len(sys.argv) > 3 else ""
        json_file_path = sys.argv[4] if len(sys.argv) > 4 else ""
        image_path = sys.argv[5] if len(sys.argv) > 5 else ""

        # Load Database from the temporary file Laravel created
        students = []
        if json_file_path and os.path.exists(json_file_path):
            try:
                with open(json_file_path, 'r') as f:
                    students = json.load(f)
            except Exception:
                students = []

        # ==========================================
        # TIER 1: DETERMINISTIC MATCH (Hardware)
        # ==========================================
        for s in students:
            if id_in and str(id_in).strip() == str(s['id_number']).strip():
                generate_output(s['id'], 100, f"Tier 1 Hardware Match: ID {id_in} perfectly verified.")

        img = None
        if image_path and os.path.exists(image_path):
            try:
                img = PIL.Image.open(image_path)
            except Exception as e:
                generate_output(None, 0, f"Image Load Failure: {str(e)}")

        # ==========================================
        # TIER 2: LOCAL OFFLINE SEMANTIC MATCH (Tesseract)
        # ==========================================
        if img:
            raw_ocr_text = pytesseract.image_to_string(img)
            best_score = 0
            best_match_id = None

            for s in students:
                name_score = semantic_similarity(raw_ocr_text, s['name'])
                id_score = semantic_similarity(raw_ocr_text, s['id_number'])
                highest_local = max(name_score, id_score) * 100

                if highest_local > best_score:
                    best_score = highest_local
                    best_match_id = s['id']

            if best_score >= 65:
                generate_output(best_match_id, best_score, f"Offline Engine Match (Local OCR): {int(best_score)}% algorithmic confidence.")
            else:
                generate_output(None, best_score, "Local Engine Scan Complete: No high-confidence match found in the directory.")
        else:
            generate_output(None, 0, "No image provided for offline scan.")

    except Exception as e:
        generate_output(None, 0, f"System Failure: {str(e)}")
