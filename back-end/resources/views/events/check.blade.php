@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Check {{ $event->name }}</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84">
        <div class="row">
            <div class="col-md-6 mx-auto py-4">
                @if (session()->has('message'))
                    <div class="alert alert-{{ session('type') }}" role="alert"> {{ session('message') }} </div>
                @endif
                <h4 class="span mb-3">{{ $event->name }}</h4>
                <p class="text-muted">Registered attendance: {{ $registered }}</p>
                <a href="{{ url('/checkAttendance/' . $event->id) }}" class="span text-muted d-block mb-3">
                    <div class="card rounded overflow-hidden p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Attendance list</span> <span>&gt;</span>
                        </div>
                    </div>
                </a>
                {{-- <a href="" class="btn btn-primary text-white w-100">
                    Send Certitficates
                </a> --}}
            </div>
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

                    <a href="{{ url('/certificates') }}" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('imgs/certificate.png') }}" alt="My certificates" />
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
