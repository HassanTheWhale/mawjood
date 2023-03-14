@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center text-center">
            {{ $qrCode }}
        </div>
    </div>
@endsection
