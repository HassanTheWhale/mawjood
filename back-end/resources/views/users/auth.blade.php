@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Verify Account</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
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
                            <label for="image" class="span ms-3 mb-1">Image</label>
                            <input type="file" class="form-control" id="image" required name="picture">
                            <small id="imageHelp" class="form-text text-muted">Please upload an image file (JPG, PNG, or
                                GIF).</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="voice" class="span ms-3 mb-1">Voice</label>
                            <input type="file" class="form-control" id="voice" required name="voice">
                            <small id="voiceHelp" class="form-text text-muted">Please upload an audio file (MP3 or
                                WAV).</small>
                        </div>
                        <button type="submit" class="btn btn-primary text-white w-100 px-4 mb-5"
                            id="submit-button">Submit</button>
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
