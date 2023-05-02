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
                            <button id="startRecordingButton" type="button" onclick="toggleRecording()"
                                class="btn btn-outline-primary" style="margin: auto">Start
                                Recording</button>
                            <button id="stopRecordingButton" onclick="stopRecording()" type="button"
                                class="btn btn-outline-danger" style="display: none; margin: auto">Stop
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

        var mediaRecorder;
        var chunks = [];
        var isRecording = false;
        var first = false;
        var audioBlob;


        function toggleRecording() {
            if (isRecording) {
                stopRecording();
            } else {
                chunks = [];
                startRecording();
            }
        }

        // when the start button is clicked, start recording
        function startRecording() {
            navigator.mediaDevices
                .getUserMedia({
                    audio: true
                })
                .then(function(stream) {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.ondataavailable = function(e) {
                        chunks.push(e.data);
                    };
                    // start the media recorder immediately
                    mediaRecorder.start();
                    isRecording = true;
                    setTimeout(function() {
                        startButton.style.display = 'none';
                        stopButton.style.display = 'block';
                    }, 500);
                })
                .catch(function(err) {
                    console.error("Error accessing microphone: " + err);
                });
        }


        // when the stop button is clicked, stop recording and play back the recorded audio
        function stopRecording() {
            mediaRecorder.stop();
            setTimeout(function() {
                isRecording = false;
                startButton.style.display = 'block';
                stopButton.style.display = 'none';

                if (chunks.length === 0) {
                    Swal.fire(
                        '',
                        'No Sound was recorded, try again',
                        'warning'
                    )
                    return;
                }

                var blob = new Blob(chunks, {
                    type: "audio/webm"
                });
                audioBlob = blob;
                var reader = new FileReader();
                reader.onload = function() {
                    var arrayBuffer = this.result;
                    var buffer = new Uint8Array(arrayBuffer);
                    var blobUrl = URL.createObjectURL(blob);
                    var link = document.getElementById('recordedAudio');
                    link.src = blobUrl;
                    // link.play();
                };
                reader.readAsArrayBuffer(blob);
            }, 500);
        }

        // get the DOM elements
        const sendButton = document.getElementById('send');
        // when the send button is clicked, send the recorded audio to the controller
        sendButton.addEventListener('click', async () => {
            if (chunks.length === 0) {
                Swal.fire(
                    '',
                    'No Sound was recorded, try again',
                    'warning'
                )
                return;
            }
            try {
                // Get the geolocation coordinates
                let latitude;
                let longitude;
                if ("geolocation" in navigator) {
                    if (window.location.protocol === "https:") {
                        const position = await new Promise((resolve, reject) => {
                            navigator.geolocation.getCurrentPosition(resolve, reject);
                        });
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Geolocation requires a secure (HTTPS) connection'
                        });
                        return; // Return early on error
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Geolocation not supported in this browser'
                    });
                    return; // Return early on error
                }

                const formData = new FormData();
                formData.append('audio', audioBlob, 'recorded_audio.webm');
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);
                formData.append('note', document.getElementById('note').value);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content');

                const response = await fetch(
                    '/voiceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                if (response.ok) {
                    location.reload();
                } else if (response.status === 404) {
                    Swal.fire(
                        'Warning',
                        'Your voice did not match the one saved',
                        'warning',
                    );
                } else if (response.status === 500) {
                    const data = await response.json();
                    Swal.fire(
                        'Warning',
                        'Your voice did not match the one saved. Error: ' + data.message,
                        'warning'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        'Unknown Error',
                        'error',
                    );
                }
            } catch (error) {
                console.error(`Error submitting form: ${error}`);
            }
        });

        // get the DOM elements
        const cancelButton = document.getElementById('cancelBtn');
        // when the send button is clicked, send the recorded audio to the controller
        cancelButton.addEventListener('click', async () => {
            try {
                // Get the geolocation coordinates
                let latitude;
                let longitude;
                if ("geolocation" in navigator) {
                    if (window.location.protocol === "https:") {
                        const position = await new Promise((resolve, reject) => {
                            navigator.geolocation.getCurrentPosition(resolve, reject);
                        });
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Geolocation requires a secure (HTTPS) connection'
                        });
                        return; // Return early on error
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Geolocation not supported in this browser'
                    });
                    return; // Return early on error
                }

                //code hereconst formData = new FormData();
                const formData = new FormData(document.getElementById('voice-check'));
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);
                formData.append('cancel', '1');
                formData.append('note', document.getElementById('note').value);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


                const response = await fetch(
                    '/voiceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                if (response.ok) {
                    location.reload();
                } else if (response.status === 404) {
                    Swal.fire(
                        'Warning',
                        'Your voice did not match the one saved',
                        'warning',
                    );
                } else if (response.status === 500) {
                    const data = await response.json();
                    Swal.fire(
                        'Warning',
                        'Your voice did not match the one saved. Error: ' + data.message,
                        'warning'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        'Unknown Error',
                        'error',
                    );
                }
            } catch (error) {
                console.error(`Error submitting form: ${error}`);
            }
        });
    </script>
@endsection
