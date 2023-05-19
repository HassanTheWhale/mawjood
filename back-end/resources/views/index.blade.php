@extends('layouts.master')
@section('content')
    <div class="landing d-flex justify-content-center align-items-center">
        <div class="landing-bottom h-50 mx-auto">
            <div class="landing-downlay bg-primary d-flex pt-4 justify-content-center align-items-end">
                <div
                    class="landing-downlay bg-white w-100 h-90 px-3 pb-4 overflow-auto d-flex flex-column justify-content-center align-items-center">
                    <div class="text-center">
                        <img src="./imgs/logo.png" width="150px" alt="Mawjood Logo" />
                    </div>

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
