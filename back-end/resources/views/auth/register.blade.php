@extends('layouts.master')
@section('extraCss')
    <script src="https://www.google.com/recaptcha/api.js?render=6LedlaAlAAAAAKS70s9psz1GXHNPwqDp-3hDaRVk"></script>
@endsection
@section('content')
    <div class="landing d-flex justify-content-center align-items-center">
        <div class="landing-bottom container h-80 mx-auto">
            <div class="landing-downlay bg-primary h-100 d-flex flex-column justify-content-end align-items-center">
                <h4 class="text-center mb-3 text-white">Welcome to Mawjood</h4>
                <div
                    class="landing-downlay bg-white h-90 w-100 p-3 pb-5 overflow-auto d-flex flex-column justify-content-center">
                    <h3 class="text-muted text-center mb-4">Create new account</h3>
                    <div class="text-center">
                        <div class="d-flex justify-content-around align-items-center">
                            <a href="{{ route('login.google') }}" class="btn btn-outline-danger">
                                <img src="{{ asset('imgs/google.svg') }}"
                                    alt="Social Media Icons to be replaced later with real buttons" class="mx-auto" />
                                Log In with Google
                            </a>
                            {{-- <a href="{{ route('microsoft.login') }}" class="btn btn-outline-info"> --}}
                            <a href="#" class="btn btn-outline-secondary">
                                Log In with Microsoft
                            </a>
                        </div>
                        <p class="text-muted mb-0 mt-3">or use your login information</p>

                        <hr>

                    </div>

                    <!-- login form -->
                    <form class="" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="username" class="span ms-3 mb-1"> Username </label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">@</span>
                                <input type="text" name="username" id="username" aria-label="Username"
                                    aria-describedby="basic-addon1" placeholder="mawjood"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}" required autofocus />
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class=" form-group mb-3">
                            <label for="email" class="span ms-3 mb-1"> Email </label>
                            <input type="email" name="email" id="email" placeholder="user@mawjood.org" required
                                value="{{ old('email') }}"
                                class="form-control w-100 @error('email') is-invalid @enderror" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">


                            <div class="col form-group mb-3">
                                <label for="password" class="span ms-3 mb-1"> Password </label>
                                <input type="password" name="password" id="password" placeholder="********" required
                                    class="form-control w-100 mb-1 @error('password') is-invalid @enderror" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col form-group mb-3">
                                <label for="password-confirm" class="span ms-3 mb-1"> Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password-confirm"
                                    placeholder="********" required class="form-control w-100 mb-1" />
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary text-white w-100 mb-2 py-2">
                            Register
                        </button>
                    </form>
                    <p class="text-muted text-center">
                        Do you have an account?
                        <a href="./login" class="span">Login Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
