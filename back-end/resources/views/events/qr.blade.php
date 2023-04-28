@extends('layouts.master')

@section('extraCss')
    <style>
        svg {
            width: 100%
        }
    </style>
@endsection
@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center container-fluid">
            {{ $qrCode }}
            {{-- <div class="mt-4">
                @if (!$event->closed)
                    <button onclick="openF()" class="btn btn-primary text-white w-100 px-4">Open Attendance</button>
                @else
                    <a href="{{ route('events.close', $event->id) }}">
                        <button class="btn btn-primary text-white w-100 px-4">Close Attendance</button>
                    </a>
                @endif
            </div> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        setInterval(function() {
            location.reload();
        }, 15000);
    </script>
@endsection
