@extends('layouts.master')

@section('content')
    <div class="top mh-8 pt-2 bg-prime2 text-white text-center overflow-hidden">
        <nav class="navbar navbar-dark">
            <div class="container d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h4 class="m-2">Final Verification</h4>
                <div class="collapse navbar-collapse mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/home/') }}">Home</a>
                        </li>
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/search') }}">Search for users</a>
                        </li>
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/followingEvent') }}">My Following
                                Events</a>
                        </li>
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/profile') }}">My Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="content h-84 py-5">
        <div class="container py-5">
            <form id="voice-check">
                <div class="row">
                    <div class="col-md-6 mx-auto text-center py-5">
                        <label class="span text-start d-block mb-3">Voice Recording</label>
                        <p class="text-muted text-start"> You must say: 'Hello. My name is {{ $myuser->name }}. I am
                            approving my sound
                            to
                            Mawjood Application'.</p>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <audio id="recordedAudio" controls></audio>
                            <button id="startRecordingButton" type="button" class="btn btn-outline-primary"
                                style="margin: auto">Start
                                Recording</button>
                            <button id="stopRecordingButton" type="button" class="btn btn-outline-danger"
                                style="display: none; margin: auto">Stop
                                Recording</button>
                        </div>
                        <div id="waveform"></div>
                        <div class="mb-3">
                            <label for="note" class="span text-start d-block">Note Section</label>
                            <p class="text-muted text-start">Add your comments here if you have any comment.</p>
                            <textarea name="note" id="note" placeholder="Add your notes here." class="form-control"></textarea>
                        </div>
                        <input type="hidden" id="cancel" name="cancel" value="">

                        <button type="button" id="send" class="btn btn-primary text-white">Send Voice & Note</button>
                        <button type="button" id="cancelBtn" class="btn btn-outline-primary">Skip Voice & Send
                            Note</button>
                    </div>
                </div>
            </form>
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
            stopButton.style.display = 'block';
            startButton.style.display = 'none';
            navigator.mediaDevices.getUserMedia({
                    audio: true
                })
                .then(stream => {
                    // create a new MediaRecorder instance
                    mediaRecorder = new MediaRecorder(stream, {
                        type: 'audio',
                        mimeType: 'audio/webm'
                    });

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
            stopButton.style.display = 'none';
            startButton.style.display = 'block';
            mediaRecorder.stop();
            mediaRecorder.addEventListener('stop', () => {
                const audioBlob = new Blob(chunks, {
                    type: 'audio/webm'
                });
                const audioURL = URL.createObjectURL(audioBlob);
                recordedAudio.src = audioURL;
                recordedAudio.controls = true;
                // recordedAudio.play();
            });
        });

        // get the DOM elements
        const sendButton = document.getElementById('send');
        // when the send button is clicked, send the recorded audio to the controller
        sendButton.addEventListener('click', () => {
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const audioBlob = new Blob(chunks, {
                    type: 'audio/webm'
                });
                const formData = new FormData();
                formData.append('audio', audioBlob, 'recorded_audio.webm');
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);
                formData.append('note', document.getElementById('note').value);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch("https://mawjood.click/voiceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        response.text().then(data => {
                            console.log(`Response message: ${data}`);
                        });
                        if (response.status == 200)
                            location.reload();
                        else if (response.status == 404)
                            Swal.fire('Warning', 'Voice did not match!', 'warning');
                    })
                    .catch(error => {
                        console.error(`Error submitting form: ${error}`);
                    });
            }, error => {
                console.error(`Error getting geolocation coordinates: ${error}`);
            });
        });

        // get the DOM elements
        const cancelButton = document.getElementById('cancelBtn');
        // when the send button is clicked, send the recorded audio to the controller
        cancelButton.addEventListener('click', () => {
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const formData = new FormData();
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);
                formData.append('cancel', '1');
                formData.append('note', document.getElementById('note').value);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch("https://mawjood.click/voiceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}", {
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
