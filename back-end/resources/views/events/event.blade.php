@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">{{ $event->name }}</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84">
        <div class="w-100 h-30"
            style="
        background-image: url({{ $event->picture }});
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      ">
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="p-2">
                    <h4 class="span mb-3">{{ $event->name }}</h4>
                    <small>
                        {{-- <p class="text-muted">Sun - Mon - Thurs</p> --}}
                        <p class="text-muted">
                            From: {{ $event->start_date }} <br />
                            To: {{ $event->end_date }}
                        </p>
                        <p class="text-muted">
                            {{ $event->description }}
                        </p>
                    </small>
                    <p class="text-end mt-3 mb-1">
                        @if ($event->user_id == $myuser->id)
                            <a href="../modify/{{ $event->id }}/" class="btn btn-secondary text-white">Modify</a>
                        @else
                            <a href="../event/{{ $event->id }}/signup" class="btn btn-primary text-white">Sign Up</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="../home" class="d-block col-3 h-100 p-0">
                        <div class="active w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/home.png" alt="Home" />
                        </div>
                    </a>

                    <a href="../search" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/search.png" alt="search for user" />
                        </div>
                    </a>

                    <a href="../certificates" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/certificate.png" alt="My certificates" />
                        </div>
                    </a>

                    <a href="../profile" class="d-block col-3 h-100 p-0" id="profileButton">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/profile.png" alt="My Profile" />
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-0 col-md-3"></div>
        </div>
    </div>
@endsection
