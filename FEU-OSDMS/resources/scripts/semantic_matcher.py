import sys
import os
import json
import warnings

# THE SILENCER: Suppress the deprecation warnings polluting stdout/stderr
warnings.filterwarnings("ignore", category=FutureWarning)

# Environment overrides
os.environ['HOME'] = r'C:\Users\Joss'
os.environ['USERPROFILE'] = r'C:\Users\Joss'

# Library path injection
lib_path = r"C:\Users\Joss\AppData\Local\Packages\PythonSoftwareFoundation.Python.3.11_qbz5n2kfra8p0\LocalCache\local-packages\Python311\site-packages"
if lib_path not in sys.path:
    sys.path.append(lib_path)

try:
    import google.generativeai as genai
except ImportError as e:
    print(json.dumps({"confidence_score": 0, "breakdown": f"Import Error: {str(e)}"}))
    sys.exit(1)

def generate_output(match_id, score, msg):
    """Protocol for structured output."""
    sys.stdout.flush() # Ensure no trailing buffers
    print(json.dumps({
        "matched_student_id": match_id if score >= 75 else None,
        "confidence_score": int(score),
        "visual_score": int(score),
        "breakdown": f"Gemini V2.0: {msg}"
    }))
    sys.exit(0)

API_KEY = os.getenv('GOOGLE_API_KEY')
if not API_KEY:
    generate_output(None, 0, "API Key Missing.")

genai.configure(api_key=API_KEY)
model = genai.GenerativeModel('gemini-2.0-flash')

def get_llm_match(report_desc, student_data):
    """REST transport bypasses gRPC networking issues."""
    prompt = f"Verify identity: '{report_desc}' vs '{student_data}'. Return JSON {{'is_match': bool, 'similarity_score': float}}."
    try:
        response = model.generate_content(
            prompt,
            generation_config={"response_mime_type": "application/json"},
            transport='rest'
        )
        return json.loads(response.text)
    except Exception as e:
        return {"is_match": False, "similarity_score": 0}

if __name__ == "__main__":
    try:
        name_in, id_in, prog_in = sys.argv[1], sys.argv[2], sys.argv[3]
        students = json.loads(sys.argv[4])

        # Step 1: Direct ID Check
        for s in students:
            if id_in and str(id_in).strip() == str(s['id_number']).strip():
                generate_output(s['id'], 100, f"ID {id_in} Verified via Directory.")

        # Step 2: Semantic Reasoning fallback
        report_text = f"Name: {name_in} | ID: {id_in}"
        for s in students:
            result = get_llm_match(report_text, f"Name: {s['name']}")
            if result.get('is_match'):
                generate_output(s['id'], int(result['similarity_score'] * 100), "Semantic Match Verified.")

        generate_output(None, 0, "Deep Semantic Analysis Complete.")
    except Exception as e:
        generate_output(None, 0, f"Runtime Error: {str(e)}")
