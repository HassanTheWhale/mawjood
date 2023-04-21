@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center">
            <div class="container">
                <form id="camera-form" class="container">
                    <input type="hidden" id="longitude" name="longitude" value="">
                    <video id="video" playsinline='true' muted='true' width="100%" autoplay='true'></video>
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
            let latitude;
            let longitude;
            if ("geolocation" in navigator) {
                if (window.location.protocol === "https:") {
                    navigator.geolocation.requestAuthorization().then(permissionStatus => {
                        if (permissionStatus === "granted") {
                            navigator.geolocation.getCurrentPosition(position => {
                                latitude = position.coords.latitude;
                                longitude = position.coords.longitude;
                            }, error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: `Error getting geolocation coordinates: ${error.message}`
                                });
                                return; // Return early on error
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Permission Denied',
                                text: 'Permission denied for geolocation'
                            });
                            return; // Return early on error
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: `Error requesting geolocation permission: ${error.message}`
                        });
                        return; // Return early on error
                    });
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
                        response.json().then(function(data) {
                            Swal.fire(
                                'Warning',
                                'Your image did not match the one saved. Error: ' + data.message,
                                'warning'
                            );
                        });
                    else Swal.fire(
                        'Error',
                        'Unknown Error',
                        'error',
                    )
                })
                .catch(error => {
                    Swal.fire(
                        'Error',
                        'Error contacting the server.',
                        'error',
                    )
                    console.error();
                });
        });

        const cancel = document.getElementById('cancel-button');
        cancel.addEventListener('click', () => {
            // Get the geolocation coordinates
            let latitude;
            let longitude;
            if ("geolocation" in navigator) {
                if (window.location.protocol === "https:") {
                    navigator.geolocation.requestAuthorization().then(permissionStatus => {
                        if (permissionStatus === "granted") {
                            navigator.geolocation.getCurrentPosition(position => {
                                latitude = position.coords.latitude;
                                longitude = position.coords.longitude;
                            }, error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: `Error getting geolocation coordinates: ${error.message}`
                                });
                                return; // Return early on error
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Permission Denied',
                                text: 'Permission denied for geolocation'
                            });
                            return; // Return early on error
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: `Error requesting geolocation permission: ${error.message}`
                        });
                        return; // Return early on error
                    });
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
                    else if (response.status == 404) {
                        response.json().then(function(data) {
                            Swal.fire(
                                'Warning',
                                'Your image did not match the one saved. Error: ',
                                'warning'
                            );
                        });
                    } else if (response.status == 500)
                        Swal.fire(
                            'Error',
                            'Your image could not be captured, please try again',
                            'error',
                        )
                    else Swal.fire(
                        'Error',
                        'Unknown Error',
                        'error',
                    )
                })
                .catch(error => {
                    console.error(`Error submitting form: ${error}`);
                });
        });
    </script>
@endsection
