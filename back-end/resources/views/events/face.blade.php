@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center">
            <form id="camera-form">
                <input type="hidden" id="latitude" name="latitude" value="">
                <input type="hidden" id="longitude" name="longitude" value="">
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

        const captureButton = document.getElementById('capture-button');
        captureButton.addEventListener('click', () => {
            // Get the geolocation coordinates
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Set the values of the hidden fields
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = latitude;

                // Continue with capturing the image and submitting the form
                const video = document.getElementById('video');
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const image = canvas.toDataURL();

                const formData = new FormData(document.getElementById('camera-form'));
                formData.append('image', image);
                formData.append('latitude', latitude);
                formData.append('latitude', latitude);

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('/faceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
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
