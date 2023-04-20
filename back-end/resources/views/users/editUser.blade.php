@extends('layouts.master')

@section('content')
    <div class="top mh-8 pt-2 bg-prime2 text-white text-center overflow-hidden">
        <nav class="navbar navbar-dark">
            <div class="container d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h4 class="m-2">Modify User</h4>
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

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-3 mx-auto">
                                    <img src="{{ asset($user->picture) }}" id="profile-image"
                                        class="rounded-circle img-fluid" alt='Profile Picture' />
                                </div>
                            </div>
                            <label for="editPicture" id="edit-profile" class="text-center w-100 my-2">
                                Edit
                            </label>
                            <input type="file" id="file-input" name="picture" accept="image/*" style="display:none;">
                        </div>

                        <div class="form-group mb-3">
                            <label for="userName" class="span ms-3 mb-1">
                                Name
                            </label>
                            <input type="text" name="userName" id="userName" placeholder="Your Name"
                                class="form-control w-100 mb-1" value="{{ $user->name }}" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="userIDName" class="span ms-3 mb-1">
                                Username
                            </label>
                            <input type="text" name="userIDName" id="userIDName" placeholder="Your Username"
                                class="form-control w-100 mb-1" value="{{ $user->username }}" />
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label for="userEmail" class="span ms-3 mb-1">
                                Email
                            </label>
                            <input type="email" name="userEmail" id="userEmail" placeholder="Your e-mail"
                                class="form-control w-100 mb-1" value="{{ $user->email }}" />
                        </div> --}}

                        <div class="form-group mb-3">
                            <label for="userBio" class="span ms-3 mb-1">
                                Bio
                            </label>
                            <input type="text" name="userBio" id="userBio" placeholder="Your Bio"
                                class="form-control w-100 mb-1" value="{{ $user->bio }}" />
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label for="userPassword" class="span ms-3 mb-1">
                                Password
                            </label>
                            <input type="password" name="userPassword" id="userPassword" placeholder="Your password"
                                class="form-control w-100 mb-1" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="userPasswordConfirm" class="span ms-3 mb-1">
                                Password Confirmation
                            </label>
                            <input type="password" name="userPasswordConfirm" id="userPasswordConfirm"
                                placeholder="Your password confirmation" class="form-control w-100 mb-1" />
                        </div> --}}

                        <div class="form-check form-switch">
                            <input class="form-check-input" value="1" {{ $user->type ? 'checked' : '' }}
                                type="checkbox" role="switch" name="userPrivate" id="userPrivate">
                            <label class="form-check-label span mb-1" for="userPrivate">Private
                                account?</label>
                        </div>

                        <input type="submit" class="btn btn-primary text-white w-100 mb-3" value="Save Information">
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

@section('scripts')
    <script>
        document.getElementById("profile-image").addEventListener("click", function() {
            document.getElementById("file-input").click();
        });

        document.getElementById("edit-profile").addEventListener("click", function() {
            document.getElementById("file-input").click();
        });

        document.getElementById("file-input").addEventListener("change", (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => {
                    document.getElementById("profile-image").src = reader.result;
                };
            }
        });
    </script>
@endsection
