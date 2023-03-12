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
        <div class="container py-3">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card rounded bg-white overflow-hidden p-2 mb-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->picture }}" alt="event" width="64px" class="rounded-circle" />
                            <span class="text-muted ms-3 ">{{ $user->name }}</span>
                        </div>
                    </div>


                    <ul class="nav nav-tabs" id="myNavTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#attendance"
                                type="button" role="tab" aria-controls="home" aria-selected="true">
                                Attendance
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#absent"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">
                                Absents
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myNav">
                        <div class="tab-pane fade show active" id="attendance" role="tabpanel"
                            aria-labelledby="Attendance-tab">
                            <p class="text-muted mt-2">Attendance will show here</p>
                            <div class="row my-2">
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <img src="{{ asset('imgs/yes.png') }}" alt="event" width="16px"
                                                class="rounded-circle" />
                                            <span class="text-muted ms-1">08/12/2022 - 16:01</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary text-white">
                                            Set Absent
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <img src="{{ asset('imgs/yes.png') }}" alt="event" width="16px"
                                                class="rounded-circle" />
                                            <span class="text-muted ms-1">11/12/2022 - 12:32</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary text-white">
                                            Set Absent
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fade tab-pane" id="absent" role="tabpanel" aria-labelledby="absent-tab">
                            <p class="text-muted mt-2">Absent will show here</p>
                            <div class="row my-2  ">
                                {{-- <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <img src="{{ asset('imgs/no.png') }}" alt="event" width="16px"
                                                class="rounded-circle" />
                                            <span class="text-muted ms-1">06/12/2022</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary text-white">
                                            Set Attend
                                        </button>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>

                    <form action="" class="mt-3">
                        <div class="form-group">
                            <label for="grade" class="span mb-1 ms-3">Grade</label>
                            <input type="text" name="" id="" value="{{ $attend->grade }}"
                                class="form-control" placeholder="Enter the grade here" />
                        </div>
                    </form>
                </div>
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
