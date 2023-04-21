@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center">
            {{ $qrCode }}

            <div class="mt-4">
                @if (!$event->closed)
                    <button onclick="openF()" class="btn btn-primary text-white w-100 px-4">Open Attendance</button>
                @else
                    <a href="{{ route('events.close', $event->id) }}">
                        <button class="btn btn-primary text-white w-100 px-4">Close Attendance</button>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        async function openF() {
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
                        fetch(`/open/{{ $event->id }}/${latitude},${longitude}`, {
                                method: 'GET',
                            })
                            .then(response => {
                                if (response.ok) {
                                    location.reload();
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'Unknown Error',
                                        'error',
                                    );
                                }
                            });
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
                    'Error: ' + error,
                    'error',
                );
                console.error(error);
            }
        }
        setInterval(function() {
            location.reload();
        }, 15000);
    </script>
@endsection
