from flask import Flask, request, jsonify
import face_recognition
import numpy as np
import subprocess
import requests
import os
import uuid
import librosa
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)

@app.route('/face_recognition')
def face_recognition_endpoint():
    try:
        # Get the additional text from the request
        url = request.form['userImg']

        # Generate a unique filename for the downloaded image
        filename = str(uuid.uuid4()) + '.jpg'

        # Download the image from the URL
        response = requests.get(url)
        with open(filename, 'wb') as f:
            f.write(response.content)

        original_image = face_recognition.load_image_file(filename)

        # Get the uploaded image from the request
        uploaded_image_file = request.files['image']
        uploaded_image = face_recognition.load_image_file(uploaded_image_file)

        # Find the face in the uploaded image
        uploaded_face_locations = face_recognition.face_locations(uploaded_image)
        uploaded_face_encodings = face_recognition.face_encodings(uploaded_image, uploaded_face_locations)

        # Find the face in the original image
        original_face_locations = face_recognition.face_locations(original_image)
        original_face_encodings = face_recognition.face_encodings(original_image, original_face_locations)

        # Compare the face in the uploaded image with the faces in the original image
        matches = face_recognition.compare_faces(original_face_encodings, uploaded_face_encodings[0])

        os.remove(filename)
        # Check if there is a match
        if True in matches:
            return jsonify(match=True)
        else:
            return jsonify(match=False)
    except Exception as e:
        # Handle exceptions and return an error response
        return jsonify(match=False)

@app.route('/voice_recognition')
def voice_recognition_endpoint():

    # import recorded sound and save it
    webm = request.files['voice']
    unique_string = str(uuid.uuid4())
    old_sound = unique_string+'.webm'
    webm.save(old_sound)

    # convert it to wav and remove old
    sound = unique_string+'.wav'
    try:
         subprocess.run(['ffmpeg', '-i', old_sound, sound])
    except Exception as e:
        # Handle exception here
        print(f'Error: {e}')
        os.remove(old_sound)
        return jsonify(sim=False) 
    if os.path.exists(sound):
        print("File exists!")
    else:
        os.remove(old_sound)
        return jsonify(sim=False) 
    
    # bring other source
    url = request.form['userVoice']
    # Generate a unique filename for the downloaded audio file
    filenamea = str(uuid.uuid4()) + '.wav'
    filename = filenamea
    # Download the audio file from the URL
    response = requests.get(url)
    with open(filename, 'wb') as f:
        f.write(response.content)

    try:
        # Load the downloaded audio file using librosa
        source, _ = librosa.load(filename, sr=44100)
        target, _ = librosa.load(sound, sr=44100)
        source_mfcc = librosa.feature.mfcc(y=source, sr=44100)
        target_mfcc = librosa.feature.mfcc(y=target, sr=44100)

        sim_score = cosine_similarity(source_mfcc.T, target_mfcc.T)
        threshold = .99 
        is_same_person = bool(sim_score[0].max() > threshold)
        return jsonify(sim=is_same_person)
    except Exception as e:
        os.remove(sound)
        os.remove(filename)
        # Handle exception here
        print(f'Error: {e}')
        return jsonify(sim=False) 

@app.route("/")
def hello():
    return "Hello, World!"