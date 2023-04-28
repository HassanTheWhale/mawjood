@extends('layouts.master')

@section('content')
    <div class="top mh-8 pt-2 bg-prime2 text-white text-center overflow-hidden">
        <nav class="navbar navbar-dark">
            <div class="container d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h4 class="m-2">Modify Events</h4>
                <div class="collapse navbar-collapse mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/home/') }}">Home</a>
                        </li>
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/search') }}">Search for users</a>
                        </li>
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/followingEvent') }}">My Following
                                Events</a>
                        </li>
                        <li class="nav-item mb-2 text-start">
                            <a class="nav-link active" aria-current="page" href="{{ url('/profile') }}">My Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="content h-84 py-4">
        <div class="container">
            @if (Session::has('errors'))
                @if ($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger" role="alert"> :message </div>')) !!}
                @endif
            @endif
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <form action="{{ route('events.modifyEvent', $event->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="eventName" class="span ms-3 mb-1">
                                Event Name
                            </label>
                            <input type="text" value="{{ $event->name }}" name="eventName" id="eventName"
                                placeholder="your event name" class="form-control w-100 mb-1" required />
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventCategory" class="span ms-3 mb-1">
                                Event Category
                            </label>
                            <select name="eventCategory" id="eventCategory" class="form-control" required
                                aria-placeholder="s">
                                @foreach ($categories as $category)
                                    @if ($category->id == $event->category)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group mb-3">
                            <label for="eventDesc" class="span ms-3 mb-1">
                                Event Description
                            </label>
                            <textarea name="eventDesc" id="eventDesc" class="form-control" required placeholder="Your Event Description">{{ $event->description }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventPic" class="span ms-3 mb-1">
                                Event Picture
                            </label>
                            <input type="file" name="eventPic" id="eventPic" accept="image/*"
                                class="form-control w-100 mb-1" />
                        </div>

                        <hr>
                        <div class="form-group mb-3">
                            <label for="date_type" class="span ms-3 mb-1"> Date Type:</label>
                            <select name="date_type" class="form-control" id="date_type">
                                <option value="single" @if ($event->type == 0) selected @endif>Single Date
                                </option>
                                <option value="range" @if ($event->type == 1) selected @endif>Date Range</option>
                            </select>
                            <br>
                            <div id="single-date" style="@if ($event->type == 1) display:none; @endif">
                                <label for="start_dateA" class="span ms-3 mb-1">Start Date:</label>
                                <input type="date" name="eventSDateA" class="form-control"
                                    min="{{ now()->format('d-m-Y') }}" max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                                    value="{{ $event->start_date }}" id="start_dateA">
                                <br>
                                <label for="start_timeA" class="span ms-3 mb-1">Start Time:</label>
                                <input type="time" name="eventSTimeA" id="start_timeA" value="{{ $event->start_time }}"
                                    class="form-control">
                                <br>
                                <label for="end_timeA" class="span ms-3 mb-1">End Time:</label>
                                <input type="time" name="eventETimeA" id="end_timeA" value="{{ $event->end_time }}"
                                    class="form-control">
                            </div>
                            <div id="range-dates" style="@if ($event->type == 0) display:none; @endif"">
                                <label for="start_dateB" class="span ms-3 mb-1">Start Date:</label>
                                <input type="date" name="eventSDateB" id="start_dateB"
                                    max="{{ date('d-m-Y', strtotime('+1 year')) }}" value="{{ $event->start_date }}"
                                    class="form-control">

                                <br>
                                <label for="end_date" class="span ms-3 mb-1">End Date:</label>
                                <input type="date" name="eventEDateB" value="{{ $event->end_date }}" id="end_date"
                                    max="{{ date('d-m-Y', strtotime('+1 year')) }}" class="form-control">

                                <br>
                                <label for="start_timeb" class="span ms-3 mb-1">Start Time:</label>
                                <input type="time" name="eventSTimeB" id="start_timeB"
                                    value="{{ $event->start_time }}"class="form-control">
                                <br>
                                <label for="end_timeb" class="span ms-3 mb-1">End Time:</label>
                                <input type="time" name="eventETimeB" id="end_timeB" value="{{ $event->end_time }}"
                                    class="form-control">
                                <br>
                                <label for="weekdays" class="span ms-3 mb-1">Weekdays:</label>
                                <br>
                                <input type="checkbox" name="weekdays[]" value="saturday"> Saturday <br>
                                <input type="checkbox" name="weekdays[]" value="sunday"> Sunday <br>
                                <input type="checkbox" name="weekdays[]" value="monday"> Monday <br>
                                <input type="checkbox" name="weekdays[]" value="tuesday"> Tuesday <br>
                                <input type="checkbox" name="weekdays[]" value="wednesday"> Wednesday <br>
                                <input type="checkbox" name="weekdays[]" value="thursday"> Thursday <br>
                                <input type="checkbox" name="weekdays[]" value="friday"> Friday <br>
                            </div>
                        </div>
                        <hr>

                        {{-- <div class="form-group mb-3">
                            @if ($event->strange)
                                <input type="checkbox" value="1" name="eventStrange" id="eventStrange" checked />
                            @else
                                <input type="checkbox" value="1" name="eventStrange" id="eventStrange" />
                            @endif
                            <label for="eventStrange" class="span ms-3 mb-1 text-muted">
                                Allow unregistered users to attend.
                            </label>
                        </div> --}}

                        <div class="form-group mb-3">
                            @if ($event->private)
                                <input type="checkbox" value="1" name="eventPrivate" id="eventPrivate" checked />
                            @else
                                <input type="checkbox" value="1" name="eventPrivate" id="eventPrivate" />
                            @endif

                            <label for="eventPrivate" class="span ms-3 mb-1 text-muted">
                                Private Event
                            </label>
                        </div>

                        <input type="submit" value="Modify the Event" class="btn btn-primary text-white w-100" />
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
                        <div class="active w-100 h-100 d-flex justify-content-center align-items-center">
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
@section('scripts')
    <script>
        const dateTypeSelect = document.getElementById('date_type');
        const singleDateFields = document.getElementById('single-date');
        const rangeDateFields = document.getElementById('range-dates');


        dateTypeSelect.addEventListener('change', () => {
            if (dateTypeSelect.value === 'single') {
                singleDateFields.style.display = 'block';
                rangeDateFields.style.display = 'none';
            } else {
                singleDateFields.style.display = 'none';
                rangeDateFields.style.display = 'block';
            }
        });
    </script>
@endsection
