@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Events</h4>
            </div>
            <a href="../create" class="col-2 pe-5 h-100 d-flex justify-content-center align-items-center">
                <img src="../imgs/plus.png" alt="Events" />
            </a>
        </div>
    </div>
    <div class="content h-84 py-4">
        <div class="container">
            <input type="text" name="search" id="search" class="form-control mb-5" autofocus
                placeholder="What are you looking for?" />

            <div class="row">
                <div class="col-12">
                    {{-- @if (count($events) == 0) --}}
                    <p>There are {{ count($events) }} events in this category.</p>
                    {{-- @endif --}}
                </div>
                @foreach ($events as $event)
                    <div class="event col-md-4 mb-3" name="{{ $event->name }}">
                        <div class="card rounded overflow-hidden">
                            @if (str_starts_with($event->picture, 'https'))
                                <img src="{{ $event->picture }}" alt="event" />
                            @else
                                <img src="{{ asset('storage/images/' . $event->picture) }}" alt="event" />
                            @endif
                            <div class="p-2">
                                <h4 class="span mb-3">{{ $event->name }}</h4>
                                <p class="text-muted">
                                    <small>
                                        {{ $event->description }}
                                    </small>
                                </p>
                                <p class="text-end mt-3 mb-1">
                                    <a href="/event/{{ $event->id }}" class="btn btn-primary text-white">Check
                                        Details</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="{{ url('/home/') }}" class="d-block col-3 h-100 p-0">
                        <div class="active w-100 h-100 d-flex justify-content-center align-items-center">
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
        const searchBox = document.getElementById('search');
        const listItems = document.querySelectorAll('.event');
        searchBox.addEventListener('keyup', (event) => {
            const searchTerm = event.target.value.toLowerCase();

            listItems.forEach((item) => {
                if (item.textContent.toLowerCase().includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endsection
