import sys
import json
import os
import traceback

try:
    import google.generativeai as genai
except ImportError:
    print(json.dumps({"error": "google.generativeai package not installed. Run: pip install google-generativeai"}))
    sys.exit(1)
GOOGLE_API_KEY = os.getenv('GOOGLE_API_KEY', 'YOUR_ACTUAL_API_KEY_HERE') 

if not GOOGLE_API_KEY or 'YOUR_ACTUAL' in GOOGLE_API_KEY:

     GOOGLE_API_KEY = "AIzaSyDZRKaiN0iYoxs0KOICpKhf2y6zoXFAU78" 

if not GOOGLE_API_KEY:
    print(json.dumps({"error": "Google API Key not configured."}))
    sys.exit(1)

try:
    genai.configure(api_key=GOOGLE_API_KEY)
    
    model = genai.GenerativeModel('gemini-2.0-flash')
    
except Exception as e:
    error_msg = f"API Configuration Error: {str(e)}\n{traceback.format_exc()}"
    print(json.dumps({"error": error_msg}))
    sys.exit(1)

def get_semantic_match_score(lost_item_desc, found_item_ocr_text):

    ##Uses Gemini to compare two text descriptions and return a JSON object.

    
    prompt = f"""
    You are a lost and found matching assistant.
    Compare the following two pieces of text.
    - Text A is a student's 'lost item' report.
    - Text B is the raw text extracted by OCR from a 'found item'.
    
    TEXT A: "{lost_item_desc}"
    TEXT B: "{found_item_ocr_text}"
    
    Do these two texts likely refer to the same item?
    
    Respond with ONLY a JSON object in the following format:
    {{
      "is_match": boolean,
      "similarity_score": float (from 0.0 to 1.0),
      "reason": "A brief explanation for your decision."
    }}
    """
    
    try:
        generation_config = genai.GenerationConfig(response_mime_type="application/json")
        response = model.generate_content(prompt, generation_config=generation_config)
        result = response.text
        # Validates if it's valid JSON
        json.loads(result)
        return result
        
    except json.JSONDecodeError as e:
        return json.dumps({"error": f"API returned invalid JSON: {e}"})
    except Exception as e:
        error_trace = traceback.format_exc()
        return json.dumps({"error": f"API call failed: {str(e)}", "details": error_trace})

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Invalid arguments. Expected 2 text strings."}))
        sys.exit(1)
        
    text_a = sys.argv[1]
    text_b = sys.argv[2]
    
    result_json_string = get_semantic_match_score(text_a, text_b)
    print(result_json_string)