@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">My Events</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84 py-4">
        <div class="container">
            <div class="row">
                <div class="col-0 col-md-3"></div>
                <div class="col-12 col-md-6">
                    @if (session()->has('type'))
                        <div class="alert alert-{{ session('type') }}" role="alert"> {{ session('message') }} </div>
                    @endif
                    <a href="myList" class="span text-muted mb-3 d-block">
                        <div class="card rounded overflow-hidden p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>My Events</span> <span>&gt;</span>
                            </div>
                        </div>
                    </a>

                    <a href="create" class="span text-muted d-block mb-3">
                        <div class="card rounded overflow-hidden p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Create Events</span> <span>&gt;</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-0 col-md-3"></div>
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="./home" class="d-block col-3 h-100 p-0">
                        <div class="active w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/home.png" alt="Home" />
                        </div>
                    </a>

                    <a href="./search" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/search.png" alt="search for user" />
                        </div>
                    </a>

                    <a href="./certificates" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/certificate.png" alt="My certificates" />
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
