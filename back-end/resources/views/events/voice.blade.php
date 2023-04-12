@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Voice Verification</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84 py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6 mx-auto text-center py-5">
                    <div class="mb-3">
                        <p>Hello, You need now to verify your voice!</p>
                        <p id="status" class="text-success">Recording is stoped!</p>
                        <button id="startRecordingButton" class="btn btn-outline-primary">Start
                            Recording</button>
                        <button id="stopRecordingButton" class="btn btn-outline-danger">Stop Recording</button>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted">Sound will be shown here</p>
                        <audio id="recordedAudio" controls></audio>
                    </div>
                    <button id="send" class="btn btn-primary text-white">Send Voice</button>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="{{ url('/home/') }}" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('imgs/home.png') }}" alt="Home" />
                        </div>
                    </a>

                    <a href="{{ url('/search') }}" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('imgs/search.png') }}" alt="search for user" />
                        </div>
                    </a>

                    <a href="{{ url('/followingEvent') }}" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('imgs/followingEvent.png') }}" alt="My followingEvent" />
                        </div>
                    </a>

                    <a href="{{ url('/profile') }}" class="d-block col-3 h-100 p-0" id="profileButton">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('imgs/profile.png') }}" alt="My Profile" />
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-0 col-md-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // get the DOM elements
        const startButton = document.getElementById('startRecordingButton');
        const stopButton = document.getElementById('stopRecordingButton');
        const recordedAudio = document.getElementById('recordedAudio');

        let mediaRecorder;
        let chunks = [];

        // when the start button is clicked, start recording
        startButton.addEventListener('click', () => {
            document.getElementById('status').classList = 'text-danger';
            document.getElementById('status').innerText = "Recording on going!";
            navigator.mediaDevices.getUserMedia({
                    audio: true
                })
                .then(stream => {
                    // create a new MediaRecorder instance
                    mediaRecorder = new MediaRecorder(stream);

                    // start recording and push chunks to the chunks array
                    mediaRecorder.addEventListener('dataavailable', event => {
                        chunks.push(event.data);
                    });
                    mediaRecorder.start();
                })
                .catch(error => console.error(error));
        });

        // when the stop button is clicked, stop recording and play back the recorded audio
        stopButton.addEventListener('click', () => {
            document.getElementById('status').classList = 'text-success';
            document.getElementById('status').innerText = "Recording is off";
            mediaRecorder.stop();
            mediaRecorder.addEventListener('stop', () => {
                const audioBlob = new Blob(chunks);
                const audioURL = URL.createObjectURL(audioBlob);
                recordedAudio.src = audioURL;
                recordedAudio.controls = true;
                recordedAudio.play();
            });
        });

        // get the DOM elements
        const sendButton = document.getElementById('send');
        // when the send button is clicked, send the recorded audio to the controller
        sendButton.addEventListener('click', () => {
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const audioBlob = new Blob(chunks);
                const formData = new FormData();
                formData.append('audio', audioBlob, 'recorded_audio.wav');
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('/voiceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (response.status == 200)
                            location.reload();
                    })
                    .catch(error => {
                        console.error(`Error submitting form: ${error}`);
                    });
            }, error => {
                console.error(`Error getting geolocation coordinates: ${error}`);
            });
        });
    </script>
@endsection
