@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center">
            <div class="container">
                <form id="camera-form" class="mx-auto">
                    <input type="hidden" id="longitude" name="longitude" value="">
                    <video id="video" playsinline='true' muted='true' width="750px" autoplay='true'></video>
                    <button type="button" class="btn btn-primary text-white w-100 px-4 mb-1" id="capture-button">Take a
                        picture</button>
                    <button type="button" class="btn btn-outline-primary text-white w-100 px-4 mb-5"
                        id="cancel-button">Skip</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        try {
            // Get access to the device camera
            const video = document.getElementById('video');

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(error => {
                    Swal.fire(
                        'Warning',
                        `Error accessing device camera: ${error.name}`,
                        'warning'
                    );
                    console.error(`Error accessing device camera: ${error}`);
                });
        } catch (error) {
            Swal.fire(
                'Warning',
                'Your browser cannot open the camera',
                'warning'
            );
            console.error(`Error accessing device camera: ${error}`);
        }


        const captureButton = document.getElementById('capture-button');
        captureButton.addEventListener('click', async () => {
            try {
                // Check for geolocation support
                if ("geolocation" in navigator) {
                    // Check for secure (HTTPS) connection
                    if (window.location.protocol === "https:") {
                        // Get current position
                        const position = await new Promise((resolve, reject) => {
                            navigator.geolocation.getCurrentPosition(resolve, reject);
                        });
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
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
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                        const response = await fetch(
                            'https://mawjood.click/faceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
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
                                'Your image did not match the one saved',
                                'warning',
                            );
                        } else if (response.status === 500) {
                            const data = await response.json();
                            Swal.fire(
                                'Warning',
                                'Your image did not match the one saved. Error: ' + data.message,
                                'warning'
                            );
                        } else {
                            Swal.fire(
                                'Error',
                                'Unknown Error',
                                'error',
                            );
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Geolocation requires a secure (HTTPS) connection'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Geolocation not supported in this browser'
                    });
                }
            } catch (error) {
                Swal.fire(
                    'Error',
                    'Error capturing image or contacting the server. Error:' + error,
                    'error',
                );
                console.error(error);
            }
        });


        const cancel = document.getElementById('cancel-button');
        cancel.addEventListener('click', async () => {
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

                const formData = new FormData(document.getElementById('camera-form'));
                formData.append('cancel', '1');
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(
                    'https://mawjood.click/faceCheck/{{ $event->id }}/{{ $myuser->id }}/{{ $instance->id }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                if (response.status == 200) {
                    location.reload();
                } else if (response.status == 404) {
                    const data = await response.json();
                    Swal.fire(
                        'Warning',
                        'Your image did not match the one saved. Error: ',
                        'warning'
                    );
                } else if (response.status == 500) {
                    Swal.fire(
                        'Error',
                        'Your image could not be captured, please try again',
                        'error',
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
