from flask import Flask, request, jsonify
import face_recognition
import numpy as np
import subprocess
import requests
import os
import uuid
import librosa
from pydub import AudioSegment
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)

@app.route('/face_recognition')
def face_recognition_endpoint():
     # Get the additional text from the request
    url = request.form['userImg']

    # Generate a unique filename for the downloaded image
    filename = str(uuid.uuid4())

    # Download the image from the URL
    response = requests.get(url)
    with open(filename, 'wb') as f:
        f.write(response.content)
    try:
        original_image = face_recognition.load_image_file(filename)

        # Get the uploaded image from the request
        uploaded_image_file = request.files['image']
        # uploaded_image_file.save('a')

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
        os.remove(filename)
        return jsonify(match=False)

@app.route('/voice_recognition')
def voice_recognition():
    # Get the URLs of the three audio files
    audio_url_1 = request.form['userVoiceA']
    audio1 = str(uuid.uuid4())
    audio_url_2 = request.form['userVoiceB']
    audio2 = str(uuid.uuid4())
    audio_url_3 = request.form['userVoiceC']
    audio3 = str(uuid.uuid4())

    sound_file = request.files['voice']
    soundN = str(uuid.uuid4())
    webm = soundN+'.webm'
    sound_file.save(webm)

    print(1)

    # Download the audio files and convert them to WAV format
    audio_file_1 = download_and_convert_to_wav(audio_url_1, audio1)
    audio_file_2 = download_and_convert_to_wav(audio_url_2, audio2)
    audio_file_3 = download_and_convert_to_wav(audio_url_3, audio3)
    print('-- done 2')

    # Load the sound file and convert it to WAV format
    sound_file_wav = soundN+'.wav'
    subprocess.call(['ffmpeg', '-i', soundN+'.webm', sound_file_wav])
    os.remove(webm)
    print('-- done 3')

    # Load the audio files as AudioSegment objects
    audio_1 = AudioSegment.from_file(audio_file_1)
    audio_2 = AudioSegment.from_file(audio_file_2)
    audio_3 = AudioSegment.from_file(audio_file_3)
    sound = AudioSegment.from_file(sound_file_wav)

    # Compare the sound file with the three audio files
    similarity_1 = compare_audio_segments(sound, audio_1)
    similarity_2 = compare_audio_segments(sound, audio_2)
    similarity_3 = compare_audio_segments(sound, audio_3)

    # Delete the temporary audio files
    os.remove(audio_file_1)
    os.remove(audio_file_2)
    os.remove(audio_file_3)
    os.remove(sound_file_wav)

    avg = similarity_1  + similarity_2 + similarity_3
    avg = avg / 3
    if (avg > 50):
        return jsonify(sim=True)
    return jsonify(sim=False)

def download_and_convert_to_wav(audio_url, name):
    # Download the audio file
    audio_response = requests.get(audio_url)
    audio_file = name + 'old'
    with open(audio_file, 'wb') as f:
        f.write(audio_response.content)

    # Convert the audio file to WAV format using ffmpeg
    subprocess.call(['ffmpeg', '-i', audio_file, name+'.wav'])

    # Delete the original audio file
    os.remove(audio_file)

    # Return the path to the WAV file
    return name + '.wav'

def compare_audio_segments(sound_1, sound_2):
    # Compare the two audio segments using the dBFS method
    similarity = sound_1.dBFS - sound_2.dBFS

    # Return the similarity as a percentage
    return (similarity + 100) / 2


@app.route("/")
def hello():
    return "Hello, World!"