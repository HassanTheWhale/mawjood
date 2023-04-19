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
                    @if (session()->has('message'))
                        <div class="alert alert-{{ session('type') }}" role="alert"> {{ session('message') }} </div>
                    @endif
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
                                @foreach ($attendedDay as $aday)
                                    <div class="col-12 mb-2 card py-3">
                                        <div class="d-flex justify-content-between align-items-center ">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <img src="{{ asset('imgs/yes.png') }}" alt="event" width="16px"
                                                    class="rounded-circle" />
                                                <span class="text-muted ms-1">{{ $aday->date }}</span>
                                            </div>
                                            <a
                                                href="{{ route('events.setAbsent', ['eid' => $event->id, 'uid' => $user->id, 'date' => $aday->date]) }}">
                                                <button class="btn btn-sm btn-primary text-white">
                                                    Set Absent
                                                </button>
                                            </a>
                                        </div>
                                        <div class="mt-2">
                                            <p class="span">System Notes:</p>
                                            <ol>
                                                @if ($aday->face == 1)
                                                    <li>The user <span class="text-success">completed</span> the face
                                                        recognition</li>
                                                @elseif ($aday->face == 2)
                                                    <li>The user <span class="text-warning">skipped</span> the face
                                                        recognition</li>
                                                @elseif ($aday->face == 3)
                                                    <li>The user <span class="text-danger">failed</span> the face
                                                        recognition</li>
                                                @endif

                                                @if ($aday->voice == 1)
                                                    <li>The user <span class="text-success">completed</span> the voice
                                                        recognition</li>
                                                @elseif ($aday->voice == 2)
                                                    <li>The user <span class="text-warning">skipped</span> the voice
                                                        recognition</li>
                                                @elseif ($aday->voice == 3)
                                                    <li>The user <span class="text-danger">failed</span> the voice
                                                        recognition</li>
                                                @endif

                                                @if ($aday->geoCheck == 1)
                                                    <li>The user <span class="text-success">within</span> the location of
                                                        the event</li>
                                                @elseif ($aday->geoCheck == 2)
                                                    <li>The user is <span class="text-danger">not within</span> the location
                                                        of the event</li>
                                                @elseif ($aday->geoCheck == 3)
                                                    <li>The user is <span class="text-warning">Manully</span> set attend by
                                                        the host</li>
                                                @endif
                                            </ol>
                                            <p class="span">User Notes:</p>
                                            <p>{{ !$aday->note ? 'No Notes' : $aday->note }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="fade tab-pane" id="absent" role="tabpanel" aria-labelledby="absent-tab">
                            <p class="text-muted mt-2">Absent will show here</p>
                            <div class="row my-2  ">
                                @foreach ($absentDays as $aday)
                                    <div class="col-12 mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <img src="{{ asset('imgs/no.png') }}" alt="event" width="16px"
                                                    class="rounded-circle" />
                                                <span class="text-muted ms-1">{{ $aday }}</span>
                                            </div>
                                            <a
                                                href="{{ route('events.setAttend', ['eid' => $event->id, 'uid' => $user->id, 'date' => $aday]) }}">
                                                <button class="btn btn-sm btn-primary text-white">
                                                    Set Attend
                                                </button>

                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- <form action="{{ route('events.updateGrade', ['eid' => $event->id, 'uid' => $user->id]) }}"
                        method="POST" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <label for="grade" class="span mb-1 ms-3">Grade</label>
                            <input type="number" name="grade" id="grade" value="{{ $attend->grade }}"
                                class="form-control" placeholder="Enter the grade here" />
                        </div>
                        <div class="text-end"><button type="submit" class="btn btn-primary text-white mt-2">Save</button>
                        </div>
                    </form> --}}

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

                    <a href="{{ url('/followingEvent') }}" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('imgs/followingEvent.png') }}" alt="My followingEvent" />
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
