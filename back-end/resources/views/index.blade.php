@extends('layouts.master')
@section('content')
    <div class="landing">
        <div class="landing-top d-flex justify-content-center align-items-center h-60">
            <img src="./imgs//logo.png" width="300px" alt="Mawjood Logo" />
        </div>
        <div class="landing-bottom h-50 mx-auto">
            <div class="landing-downlay bg-primary h-100 d-flex justify-content-center align-items-end">
                <div class="landing-downlay bg-white h-90 w-100 p-5 overflow-auto">
                    <h4 class="text-center mb-3">Welcome</h4>
                    <a href="./login" class="btn btn-primary text-white w-100 mb-3 py-2">Login to your account</a>
                    <p class="mb-0 text-muted text-center">
                        Don't have an account?
                        <a href="./register" class="span">Register Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
