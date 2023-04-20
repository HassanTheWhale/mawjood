from flask import Flask, request, jsonify
import face_recognition
import numpy as np
import subprocess
import os
import uuid
import librosa
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)

@app.route('/face_recognition')
def face_recognition_endpoint():
    # Get the additional text from the request
    original_text = request.form['userImg']
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

    #import recorded sound and save it
    webm = request.files['voice']
    unique_string = str(uuid.uuid4())
    old_sound = unique_string+'.webm'
    webm.save(old_sound)


    #convert it to wav and remove old
    sound = unique_string+'.wav'
    subprocess.run(['ffmpeg', '-i', old_sound, sound])
    os.remove(old_sound)

    #bring other source
    source = request.form['userVoice']

    source, _ = librosa.load(source, sr=44100)
    target, _ = librosa.load(sound, sr=44100)
    source_mfcc = librosa.feature.mfcc(y=source, sr=44100)
    target_mfcc = librosa.feature.mfcc(y=target, sr=44100)
    os.remove(sound)
    
    sim_score = cosine_similarity(source_mfcc.T, target_mfcc.T)
    threshold = .5  # Change this value as needed
    is_same_person = bool(sim_score[0].min() > threshold)
    return jsonify(sim=is_same_person)


@app.route("/")
def hello():
    return "Hello, World!"