@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center">
            <form id="camera-form">
                <video id="video" width="100%" autoplay></video>
                <button type="button" class="btn btn-primary text-white w-100 px-4 mb-5" id="capture-button">Take a
                    picture</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Get access to the device camera
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                const video = document.getElementById('video');
                video.srcObject = stream;
                video.play();
            })
            .catch(error => {
                console.error(`Error accessing device camera: ${error}`);
            });

        // Trigger the device camera to capture a picture
        const captureButton = document.getElementById('capture-button');
        captureButton.addEventListener('click', () => {
            const video = document.getElementById('video');
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const image = canvas.toDataURL();

            // Add the captured image to the form data
            const formData = new FormData(document.getElementById('camera-form'));
            formData.append('image', image);

            // Submit the form to the server
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/faceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
                    method: 'POST',
                    body: JSON.stringify(formData),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (response.status == 404)
                        window.location.href('/notAvailable')
                    else
                        location.reload();
                })
                .catch(error => {
                    console.error(`Error submitting form: ${error}`);
                });
        });
    </script>
@endsection
