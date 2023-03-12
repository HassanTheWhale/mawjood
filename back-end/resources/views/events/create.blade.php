@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Create Events</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
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
                    <form action="{{ route('events.createEvent') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="eventName" class="span ms-3 mb-1">
                                Event Name
                            </label>
                            <input type="text" name="eventName" id="eventName" placeholder="your event name"
                                class="form-control w-100 mb-1" required />
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventCategory" class="span ms-3 mb-1">
                                Event Category
                            </label>
                            <select name="eventCategory" id="eventCategory" class="form-control" required
                                aria-placeholder="s">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group mb-3">
                            <label for="eventDesc" class="span ms-3 mb-1">
                                Event Description
                            </label>
                            <textarea name="eventDesc" id="eventDesc" class="form-control" required placeholder="Your Event Description"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventPic" class="span ms-3 mb-1">
                                Event Picture
                            </label>
                            <input type="file" name="eventPic" id="eventPic" accept="image/*"
                                class="form-control w-100 mb-1" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventGrade" class="span ms-3 mb-1">
                                Min Grade
                            </label>
                            <input type="number" name="eventGrade" id="eventGrade"
                                placeholder="Min grade for sending certificates" required class="form-control w-100 mb-1" />
                        </div>

                        <hr>

                        <div class="form-group mb-3">
                            <label for="eventSDate" class="span ms-3 mb-1"> Start Date </label>
                            <input type="date" name="eventSDate" id="eventSDate" min="{{ now()->format('Y-m-d') }}"
                                required placeholder="" class="form-control w-100 mb-1" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventEDate" class="span ms-3 mb-1"> End Date </label>
                            <input type="date" name="eventEDate" id="eventEDate" min="{{ now()->format('Y-m-d') }}"
                                required placeholder="" class="form-control w-100 mb-1" />
                        </div>
                        {{-- 
                        <div class="form-group mb-3">
                            <label for="repeat" class="span ms-3 mb-1"> Repeat Every </label>
                            <br>
                            <input type="checkbox" value="Saturday" name="eventRepeatDay" required id="Saturday" />
                            <label for="Saturday" class="span ms-3 mb-1 text-muted">
                                Saturday
                            </label>
                            <br>
                            <input type="checkbox" value="Sunday" name="eventRepeatDay" required id="Sunday" />
                            <label for="Sunday" class="span ms-3 mb-1 text-muted">
                                Sunday
                            </label>
                            <br>
                            <input type="checkbox" value="Monday" name="eventRepeatDay" required id="Monday" />
                            <label for="Monday" class="span ms-3 mb-1 text-muted">
                                Monday
                            </label>
                            <br>
                            <input type="checkbox" value="Tuesday" name="eventRepeatDay" required id="Tuesday" />
                            <label for="Tuesday" class="span ms-3 mb-1 text-muted">
                                Tuesday
                            </label>
                            <br>
                            <input type="checkbox" value="Wendsday" name="eventRepeatDay" required id="Wendsday" />
                            <label for="Wendsday" class="span ms-3 mb-1 text-muted">
                                Wendsday
                            </label>
                            <br>
                            <input type="checkbox" value="Thursday" name="eventRepeatDay" required id="Thursday" />
                            <label for="Thursday" class="span ms-3 mb-1 text-muted">
                                Thursday
                            </label>
                            <br>
                            <input type="checkbox" value="Friday" name="eventRepeatDay" required id="Friday" />
                            <label for="Friday" class="span ms-3 mb-1 text-muted">
                                Friday
                            </label>
                        </div> --}}

                        <hr>

                        <div class="form-group mb-3">
                            <input type="checkbox" value="1" name="eventStrange" id="eventStrange" />
                            <label for="eventStrange" class="span ms-3 mb-1 text-muted">
                                Allow unregistered users to attend.
                            </label>
                        </div>

                        <div class="form-group mb-3">
                            <input type="checkbox" value="1" name="eventPrivate" id="eventPrivate" />
                            <label for="eventPrivate" class="span ms-3 mb-1 text-muted">
                                Private Event
                            </label>
                        </div>

                        <input type="submit" value="Create the Event" class="btn btn-primary text-white w-100" />
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
