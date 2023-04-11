@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Check {{ $event->name }}</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84">
        <div class="row">
            <div class="col-md-6 mx-auto py-4">
                @if (session()->has('message'))
                    <div class="alert alert-{{ session('type') }}" role="alert"> {{ session('message') }} </div>
                @endif

                <form method="POST" action="{{ route('events.privateKeyModify', $event->id) }}">
                    @csrf
                    <label for="text" class="span mb-2">Private Key:</label>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <input type="password" name="text" id="text" value="{{ $event->key }}"
                            class="me-3 form-control" readonly>
                    </div>
                    <div class="d-flex justify-content-around align-items-center">
                        <button type="button" id="toggle" class="me-3 btn btn-secondary">Show/Hide</button>
                        <button type="submit" class="btn btn-primary text-white">Generate new one</button>
                    </div>
                </form>

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
        document.addEventListener("DOMContentLoaded", function() {
            const textInput = document.getElementById("text");
            const toggleButton = document.getElementById("toggle");

            toggleButton.addEventListener("click", function() {
                if (textInput.type === "text") {
                    textInput.type = "password";
                } else {
                    textInput.type = "text";
                }
            });
        });
    </script>
@endsection
