import sys
import os
import json
import warnings

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
        "matched_student_id": match_id if score >= 75 else None,
        "confidence_score": int(score),
        "visual_score": int(score),
        "breakdown": f"Gemini ID Core: {msg}"
    }))
    sys.exit(0)

# --- SAFE IMPORTS ---
try:
    import google.generativeai as genai
    import PIL.Image
except ImportError as e:
    generate_output(None, 0, f"Critical Library Missing: {str(e)}. Please install it via command prompt.")

# --- AUTHENTICATION ---
API_KEY = os.getenv('GOOGLE_API_KEY')
if not API_KEY:
    generate_output(None, 0, "API Key Missing.")

try:
    # THE FIX: transport='rest' goes HERE, not in generate_content!
    genai.configure(api_key=API_KEY, transport='rest')
    model = genai.GenerativeModel('gemini-2.0-flash')
except Exception as e:
    generate_output(None, 0, f"Gemini Config Error: {str(e)}")


if __name__ == "__main__":
    try:
        # Args mapping (Safely handles empty arrays)
        name_in = sys.argv[1] if len(sys.argv) > 1 else ""
        id_in = sys.argv[2] if len(sys.argv) > 2 else ""
        prog_in = sys.argv[3] if len(sys.argv) > 3 else ""
        students_json_str = sys.argv[4] if len(sys.argv) > 4 else "[]"
        image_path = sys.argv[5] if len(sys.argv) > 5 else ""

        try:
            students = json.loads(students_json_str)
        except Exception:
            students = [] # Failsafe if Laravel sends broken JSON

        # Step 1: Direct Database Check (Lightning Fast Bypass)
        for s in students:
            if id_in and str(id_in).strip() == str(s['id_number']).strip():
                generate_output(s['id'], 100, f"Hardware Match: ID {id_in} verified via Directory.")

        # Step 2: Gemini ONE-SHOT Batch Request
        prompt_content = [f"""
        You are an elite university identity verification AI.
        Target Identity Data Input: Name: '{name_in}', ID: '{id_in}', Program: '{prog_in}'.

        Search this JSON database of enrolled students:
        {students_json_str}

        If you find a high-confidence match (e.g. matched photo, or slight typo in name), return a JSON object exactly like this:
        {{"matched_student_id": <int>, "confidence_score": <int 1-100>, "reason": "<string>"}}

        If absolutely no one matches, return: {{"matched_student_id": null, "confidence_score": 0, "reason": "No directory match."}}
        """]

        # Safely load the cropped ID photo
        if image_path and os.path.exists(image_path):
            try:
                img = PIL.Image.open(image_path)
                prompt_content.append(img)
                prompt_content[0] += "\nI have also provided a live capture photo of the ID card. Extract the name/ID number from the image and match it against the JSON database."
            except Exception as e:
                generate_output(None, 0, f"Image Load Failure: {str(e)}")

        # THE FIX: Removed transport='rest' from here
        response = model.generate_content(
            prompt_content,
            generation_config={"response_mime_type": "application/json", "temperature": 0.1}
        )

        result = json.loads(response.text)
        score = result.get('confidence_score', 0)
        match_id = result.get('matched_student_id')
        reason = result.get('reason', 'Deep semantic scan complete.')

        generate_output(match_id, score, reason)

    except Exception as e:
        generate_output(None, 0, f"Runtime Failure: {str(e)}")
