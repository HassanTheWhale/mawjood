@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center">
            <form id="camera-form">
                <input type="hidden" id="latitude" name="latitude" value="">
                <input type="hidden" id="cancel" name="cancel" value="">
                <input type="hidden" id="longitude" name="longitude" value="">
                <video id="video" width="100%" autoplay></video>
                <button type="button" class="btn btn-primary text-white w-100 px-4 mb-1" id="capture-button">Take a
                    picture</button>
                <button type="button" class="btn btn-outline-primary text-white w-100 px-4 mb-5"
                    id="cancel-button">Skip</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        try {
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
        } catch (error) {
            Swal.fire(
                'Warning',
                'Your browser can not open the camera',
                'warning',
            )

        }

        const captureButton = document.getElementById('capture-button');
        captureButton.addEventListener('click', () => {
            // Get the geolocation coordinates
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Set the values of the hidden fields
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;

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
                formData.append('longitude', longitude);

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('https://mawjood.click/faceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (response.status == 200)
                            location.reload();
                        else if (response.status == 404)
                            Swal.fire(
                                'Warning',
                                'Your image did not match the one saved',
                                'warning',
                            )
                        else if (response.status == 500)
                            Swal.fire(
                                'Error',
                                'Your image could not be captured, please try again',
                                'error',
                            )
                    })
                    .catch(error => {
                        console.error(`Error submitting form: ${error}`);
                    });
            }, error => {
                console.error(`Error getting geolocation coordinates: ${error}`);
            });
        });

        const cancel = document.getElementById('cancel-button');
        cancel.addEventListener('click', () => {
            // Get the geolocation coordinates
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Set the values of the hidden fields
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
                document.getElementById('cancel').value = '1';


                const formData = new FormData(document.getElementById('camera-form'));
                formData.append('cancel', '1');
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('https://mawjood.click/faceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
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
