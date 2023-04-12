In order to prepare the environment you will need to:

**Assuming that you already installed pip, python, ffmpeg**

1. cd myproject
2. python3 -m venv venv

- You will need to get inside the environment

* . venv/bin/activate -> mac
* venv\Scripts\activate -> windows

3. pip install Flask
4. pip install face-recognition
5. pip install librosa
6. flask run -> you need to set the app first using command: export FLASK_APP=project.py && set FLASK_APP=project.py
