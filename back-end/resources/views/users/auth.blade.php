@extends('layouts.master')

@section('content')
    <div class="top mh-8 pt-2 bg-prime2 text-white text-center overflow-hidden">
        <nav class="navbar navbar-dark">
            <div class="container d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h4 class="m-2">Account Verify</h4>
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
            <div class="row">
                <div class="col-md-6 mx-auto">
                    @if (Session::has('errors'))
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div class="alert alert-danger" role="alert"> :message </div>')) !!}
                        @endif
                    @endif
                    <form id="verify-form" method="post" action="{{ route('profile.verify') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="image" class="span ms-3 mb-1">Your Face Image</label>
                            <input type="file" class="form-control" id="image" required name="picture">
                            <small id="imageHelp" class="form-text text-muted">Please upload an image file (JPG,
                                PNG).</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="voice" class="span ms-3 mb-1">Voice 1:</label>
                            <input type="file" class="form-control" id="voiceA" required name="voiceA">
                            <small class="form-text text-muted">
                                You must say: 'Hello, My name is {{ $user->name }}'.</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="voice" class="span ms-3 mb-1">Voice 2:</label>
                            <input type="file" class="form-control" id="voiceB" required name="voiceB">
                            <small class="form-text text-muted">
                                You must say: 'I use mawjood to take my attendance'.</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="voice" class="span ms-3 mb-1">Voice 3:</label>
                            <input type="file" class="form-control" id="voiceC" required name="voiceC">
                            <small class="form-text text-muted">
                                You must say: 'The weather in Kuwait is amazing.'.</small>
                        </div>
                        <button type="submit" class="btn btn-primary text-white w-100 px-4 mb-2"
                            id="submit-button">Submit</button>
                        <p class="text-danger">Pay attention that, the event host and the admins will be able to see these
                            data.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom
                            h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="./home
                    " class="d-block col-3 h-100 p-0">
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
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/profile.png" alt="My Profile" />
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-0 col-md-3"></div>
        </div>
    </div>
@endsection
