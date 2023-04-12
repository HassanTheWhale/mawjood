from flask import Flask, request, jsonify
import face_recognition

app = Flask(__name__)

@app.route('/face_recognition')
def face_recognition_endpoint():
    # Get the additional text from the request
    original_text = '/Applications/XAMPP/xamppfiles/htdocs/mawjood-project/back-end/storage/app/public/' + request.form['userImg'].replace('storage/', '')
    # Load the original image
    original_image = face_recognition.load_image_file(original_text)

    # Get the uploaded image from the request
    uploaded_image_file = request.files['image']
    uploaded_image = face_recognition.load_image_file(uploaded_image_file)

    # Find all the faces in the uploaded image
    uploaded_face_locations = face_recognition.face_locations(uploaded_image)
    uploaded_face_encodings = face_recognition.face_encodings(uploaded_image, uploaded_face_locations)

    # Find all the faces in the original image
    original_face_locations = face_recognition.face_locations(original_image)
    original_face_encodings = face_recognition.face_encodings(original_image, original_face_locations)

    # Compare the faces in the uploaded image with the faces in the original image
    matches = face_recognition.compare_faces(original_face_encodings, uploaded_face_encodings[0])
    # Check if there is a match
    if True in matches:
        return jsonify(match=True)
    else:
        return jsonify(match=False)


@app.route("/")
def hello():
    return "Hello, World!"