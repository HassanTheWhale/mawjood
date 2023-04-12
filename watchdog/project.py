from flask import Flask, request, jsonify
import face_recognition
import librosa
import numpy as np
import tempfile
import os
from pydub.utils import mediainfo
import subprocess
import uuid
from pydub import AudioSegment


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

@app.route('/voice_recognition')
def voice_recognition_endpoint():
    source = '/Applications/XAMPP/xamppfiles/htdocs/mawjood-project/back-end/storage/app/public/' + request.form['userVoice'].replace('storage/', '')
    webm = request.files['voice']
    rmse = compare_audio_files(source, webm)

    # Remove the webm file
    os.remove(webm.filename)

    # Check if there is a match
    # if dist < threshold:
    #     return jsonify(match=True)
    # else:
    #     return jsonify(match=False)

def compare_audio_files(local_file_path, webm_file):
    # Save the webm file
    webm_file.save(webm_file.filename)

    # Load the WAV and WebM files
    local_audio = AudioSegment.from_file(local_file_path, format='wav')
    webm_audio = AudioSegment.from_file(webm_file.filename, format='webm')
    
    # Set both audio files to mono, 16-bit and 44.1kHz
    local_audio = local_audio.set_channels(1).set_sample_width(2).set_frame_rate(44100)
    webm_audio = webm_audio.set_channels(1).set_sample_width(2).set_frame_rate(44100)
    
    # Convert the audio files to numpy arrays for comparison
    local_audio_np = np.array(local_audio.get_array_of_samples())
    webm_audio_np = np.array(webm_audio.get_array_of_samples())
    
    # Calculate the root mean squared error (RMSE) between the two audio files
    rmse = np.sqrt(np.mean((local_audio_np - webm_audio_np)**2))

    return rmse


@app.route("/")
def hello():
    return "Hello, World!"