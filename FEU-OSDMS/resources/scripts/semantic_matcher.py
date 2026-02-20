import sys
import os
import json

# THE FAIL-SAFE: Manually define HOME if the environment doesn't provide it
# This prevents the "Could not determine home directory" crash in parso/jedi
if 'HOME' not in os.environ:
    os.environ['HOME'] = r'C:\Users\Joss'
if 'USERPROFILE' not in os.environ:
    os.environ['USERPROFILE'] = r'C:\Users\Joss'

# THE OVERRIDE: Pointing Python directly to its site-packages
lib_path = r"C:\Users\Joss\AppData\Local\Packages\PythonSoftwareFoundation.Python.3.11_qbz5n2kfra8p0\LocalCache\local-packages\Python311\site-packages"
if lib_path not in sys.path:
    sys.path.append(lib_path)

try:
    import google.generativeai as genai
except ImportError as e:
    print(json.dumps({
        "matched_student_id": None,
        "confidence_score": 0,
        "breakdown": f"SYSTEM ERROR: Google AI Module missing. {str(e)}"
    }))
    sys.exit(1)

def generate_output(match_id, score, msg):
    """Protocol for returning structured intelligence to Laravel."""
    print(json.dumps({
        "matched_student_id": match_id if score >= 75 else None,
        "confidence_score": score,
        "visual_score": score,
        "breakdown": f"Gemini V2.0: {msg}"
    }))
    sys.exit(0)

# 1. AUTHENTICATION HANDSHAKE
API_KEY = os.getenv('GOOGLE_API_KEY')

if not API_KEY:
    generate_output(None, 0, "CRITICAL: Google API Key not found.")

genai.configure(api_key=API_KEY)
model = genai.GenerativeModel('gemini-2.0-flash')

def get_llm_match(report_desc, student_data):
    """
    Uses Gemini to compare inputs with contextual reasoning.
    Forced 'rest' transport bypasses networking errors.
    """
    prompt = f"""
    You are an FEU-OSDMS Intelligence Assistant.
    Compare the following for identity verification:
    - INPUT DATA: "{report_desc}"
    - DATABASE RECORD: "{student_data}"

    Are these likely the same person? Account for typos, initials, or suffixes.
    Respond ONLY with a JSON object:
    {{
      "is_match": boolean,
      "similarity_score": float (0.0 to 1.0),
      "reason": "brief explanation"
    }}
    """
    try:
        # transport='rest' ensures we don't use crashing gRPC providers
        response = model.generate_content(
            prompt,
            generation_config={"response_mime_type": "application/json"},
            transport='rest'
        )
        return json.loads(response.text)
    except Exception as e:
        return {"is_match": False, "similarity_score": 0, "reason": str(e)}

if __name__ == "__main__":
    try:
        # ARGS: [1] Manual Name [2] Manual ID [3] Manual Program [4] Student JSON
        if len(sys.argv) < 5:
             generate_output(None, 0, "ERROR: Insufficient arguments from Terminal.")

        name_in = sys.argv[1]
        id_in = sys.argv[2]
        prog_in = sys.argv[3]
        students = json.loads(sys.argv[4])

        # STEP 1: HARDWARE ANCHOR (ID Number Check)
        # If the ID number matches exactly, it is a 100% verified match.
        for s in students:
            if id_in and str(id_in).strip() == str(s['id_number']).strip():
                generate_output(s['id'], 100, f"Hardware Match: ID {id_in} verified.")

        # STEP 2: SEMANTIC REASONING (The Brain)
        best_match = None
        highest_score = 0
        report_text = f"Name: {name_in} | ID: {id_in} | Program: {prog_in}"

        for s in students:
            db_text = f"Name: {s['name']} | ID: {s['id_number']}"
            result = get_llm_match(report_text, db_text)

            current_score = int(result.get('similarity_score', 0) * 100)
            if result.get('is_match') and current_score > highest_score:
                highest_score = current_score
                best_match = s['id']
                if highest_score >= 98: break # Optimization: Early exit

        generate_output(best_match, highest_score, "Deep Semantic Analysis Complete.")

    except Exception as e:
        generate_output(None, 0, f"Engine Failure: {str(e)}")
