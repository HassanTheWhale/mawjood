@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">{{ $event->name }}</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84">
        <div class="w-100 h-30"
            style="
        background-image: url({{ $event->picture }});
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      ">
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="p-2">
                    @if (session()->has('message'))
                        <div class="alert alert-{{ session('type') }}" role="alert"> {{ session('message') }} </div>
                    @endif
                    <h4 class="span mb-3">{{ $event->name }}</h4>
                    <small>
                        {{-- <p class="text-muted">Sun - Mon - Thurs</p> --}}
                        <p class="text-muted">

                            @if ($event->start_date == $event->end_date)
                                Date: {{ $event->start_date }} <br />
                            @else
                                Date Range: <br>
                                @foreach ($dates as $date)
                                    &nbsp; {{ date('l, d/m/Y', strtotime($date->date)) }}
                                    <br>
                                @endforeach
                            @endif
                            <br>
                            Time From: {{ Carbon\Carbon::createFromFormat('H:i:s', $event->start_time)->format('h:i A') }} -
                            To:
                            {{ Carbon\Carbon::createFromFormat('H:i:s', $event->end_time)->format('h:i A') }}
                        </p>
                        <p class="text-muted">
                            {{ $event->description }}
                        </p>
                    </small>
                    <p class="text-end mt-3 mb-1">
                        @if ($event->user_id == $myuser->id)
                            <div class="d-flex justify-content-around align-items-center">
                                <a href="#" onclick="removeEvent()" class="btn btn-outline-danger">Remove
                                    Event</a>
                                <a href="../modify/{{ $event->id }}/" class="btn btn-outline-secondary">Modify
                                    Event</a>
                                <a href="../check/{{ $event->id }}/" class="btn btn-outline-primary">Check
                                    Event</a>
                                <a href="../generateQR/{{ $event->id }}/" class="btn btn-primary text-white">QR Code</a>
                            </div>
                        @elseif ($attend)
                            <a href="../event/{{ $event->id }}/withdraw"
                                class="btn btn-secondary text-white">Withdraw</a>
                        @else
                            <a href="../event/{{ $event->id }}/signup" class="btn btn-primary text-white">Sign Up</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="../home" class="d-block col-3 h-100 p-0">
                        <div class="active w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/home.png" alt="Home" />
                        </div>
                    </a>

                    <a href="../search" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/search.png" alt="search for user" />
                        </div>
                    </a>

                    <a href="../certificates" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/certificate.png" alt="My certificates" />
                        </div>
                    </a>

                    <a href="../profile" class="d-block col-3 h-100 p-0" id="profileButton">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="../imgs/profile.png" alt="My Profile" />
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
        function removeEvent() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#56c4cf',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    container: 'my-swal-container'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../remove/{{ $event->id }}'
                }
            })
        }
    </script>
@endsection
