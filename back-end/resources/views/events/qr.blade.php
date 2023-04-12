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
        function openF() {

            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                fetch(`/open/{{ $event->id }}/${latitude},${longitude}`, {
                        method: 'GET',
                    })
                    .then(response => {
                        if (response.status == 200)
                            location.reload();
                    });
            });
        }
        setInterval(function() {
            location.reload();
        }, 15000);
    </script>
@endsection
