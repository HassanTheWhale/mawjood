@extends('layouts.master')
@section('content')
    <div class="landing">
        <div class="landing-top d-flex justify-content-center align-items-center h-30">
            <img src="./imgs//logo.png" width="200px" alt="Mawjood Logo" />
        </div>
        <div class="landing-bottom h-70 mx-auto">
            <div class="landing-downlay bg-primary h-100 d-flex flex-column justify-content-end align-items-center">
                <h4 class="text-center mb-3 text-white">Login to your account</h4>
                <div class="landing-downlay bg-white h-90 w-100 p-3 overflow-auto">
                    <div class="text-center mb-5">
                        {{-- <img src="./imgs/social media.png" alt="Social Media Icons to be replaced later with real buttons"
                            class="mx-auto" />
                        <p class="text-muted">or use your login information</p> --}}
                        <h3 class="text-muted mb-3">Welcome to Mawjood</h3>
                    </div>

                    <!-- login form -->
                    <form class="mb-5" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="username" class="span ms-3 mb-1"> Username </label>
                            <input type="text" name="username" id="username" placeholder="@mawjood"
                                class="form-control w-100 @error('username') is-invalid @enderror"
                                value="{{ old('username') }}" required autofocus />
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="span ms-3 mb-1"> Password </label>
                            <input type="password" name="password" id="password" placeholder="********"
                                class="form-control w-100 mb-1 @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <!-- <div class="d-flex justify-content-end">
                                              <a href="" class="span text-muted">Forgot your password?</a>
                                            </div> -->
                        </div>
                        <button type="submit" class="btn btn-primary text-white w-100 mb-3 py-2">Login</button>
                    </form>
                    <p class="mb-0 text-muted text-center">
                        Don't have an account?
                        <a href="./register" class="span">Register Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
