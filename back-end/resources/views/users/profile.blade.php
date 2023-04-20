@extends('layouts.master')

@section('content')
    <div class="top mh-8 pt-2 bg-prime2 text-white text-center overflow-hidden">
        <nav class="navbar navbar-dark">
            <div class="container d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h4 class="m-2">{{ '@' . $user->username }}</h4>
                <a href="#" onclick="settings()"
                    class="col-2 pe-5 h-100 d-flex justify-content-center align-items-center">
                    <img src="./imgs/dots.png" width="32px" alt="Events" />
                </a>
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
    <div class="content h-84">
        <div class="container-fluid py-3">
            <div class="row">
                <div class="col-0 col-md-3"></div>
                <div class="col-0 col-md-6">
                    @if (!$verified)
                        <div class="alert alert-danger" role="alert"> Your account is not verified! <a
                                href="{{ route('profile.verify') }}">Verify It!</a> </div>
                    @endif
                    <div class="row">
                        <div class="col-3 mt-3">
                            <img src='{{ asset($user->picture) }}' class="rounded-circle img-fluid"
                                alt={{ '@' . $user->username . ' Profile Picture' }} />
                        </div>
                        <div class="col-9 mt-4">
                            <div class="row text-center">
                                <div class="col-6">
                                    {{ $countFollowers }} <br />
                                    Followers
                                </div>
                                <div class="col-6">
                                    {{ $countFollowing }} <br />
                                    Following
                                </div>
                                <div class="col-12 mt-3 text-start">
                                    <h3>{{ $user->name }}</h3>
                                    <small>
                                        <p class="text-muted">
                                            {{ $user->bio }}
                                        </p>
                                    </small>
                                </div>
                                <div class="col-12 mt-3 d-flex justify-content-around align-items-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-0 col-md-3"></div>
                <div class="col-12 mb-2">
                    <div class="col-12 mt-4">
                        <div class="container row m-0">
                            @foreach ($events as $event)
                                <div class="event col-md-4 mb-3" name="{{ $event->name }}">
                                    <div class="card rounded overflow-hidden">
                                        <img src="{{ asset($event->picture) }}" alt="event" />
                                        <div class="p-2">
                                            <h4 class="span mb-3">{{ $event->name }}</h4>
                                            <p class="text-muted">
                                                <small>
                                                    {{ $event->description }}
                                                </small>
                                            </p>
                                            <p class="text-end mt-3 mb-1">
                                                <a href="/event/{{ $event->id }}"
                                                    class="btn btn-primary text-white">Check
                                                    Details</a>
                                                <a href="/modify/{{ $event->id }}"
                                                    class="btn btn-secondary text-white">Modify</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="./home" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/home.png" alt="Home" />
                        </div>
                    </a>

                    <a href="./search" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/search.png" alt="search for user" />
                        </div>
                    </a>

                    <a href="./followingEvent" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/followingEvent.png" alt="My followingEvent" />
                        </div>
                    </a>

                    <a href="#" class="d-block col-3 h-100 p-0" id="profileButton">
                        <div class="w-100 active h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/profile.png" alt="My Profile" />
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
        function settings() {
            profileModal.toggle();
        }
    </script>
@endsection
