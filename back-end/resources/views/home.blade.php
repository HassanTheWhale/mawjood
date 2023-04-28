@extends('layouts.master')

@section('content')
    <div class="top mh-8 pt-2 bg-prime2 text-white text-center overflow-hidden">
        <nav class="navbar navbar-dark">
            <div class="container d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h4 class="m-2">Events</h4>
                <a href="./create" class="col-2 pe-5 h-100 ">
                    <img src="./imgs/plus.png" alt="Events" />
                </a>
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
            @if (session()->has('message'))
                <div class="alert alert-{{ session('type') }}" role="alert"> {{ session('message') }} </div>
            @endif
            <form action="{{ route('home') }}" method="GET" id="search-form">
                <input type="text" name="search" value="{{ $query }}" id="search" class="form-control mb-5"
                    onfocus="setTimeout(() => moveCursorToEnd(this), 0)" autofocus
                    placeholder="What are you looking for?" />
            </form>
            <div class="row">
                @if (isset($events))
                    @foreach ($events as $event)
                        <div class="event col-md-4 mb-3" name="{{ $event->name }}">
                            <div class="card rounded overflow-hidden">
                                <img src="{{ asset($event->picture) }}" alt="event" />
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
                @else
                    @foreach ($catergories as $category)
                        <div class="category col-md-4 mb-3" name="{{ $category->name }}">
                            <div class="card rounded overflow-hidden">
                                <img src="{{ $category->picture }}" alt="event" />
                                <div class="p-2">
                                    <h4 class="span mb-3">{{ $category->name }}</h4>
                                    <p class="text-end mt-3 mb-1">
                                        <a href="/category/{{ $category->id }}" class="btn btn-primary text-white">Check
                                            Events</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="./home" class="d-block col-3 h-100 p-0">
                        <div class="w-100 active h-100 d-flex justify-content-center align-items-center">
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
        // const searchBox = document.getElementById('search');
        // const listItems = document.querySelectorAll('.category');
        // searchBox.addEventListener('keyup', (event) => {
        //     const searchTerm = event.target.value.toLowerCase();

        //     listItems.forEach((item) => {
        //         if (item.textContent.toLowerCase().includes(searchTerm)) {
        //             item.style.display = '';
        //         } else {
        //             item.style.display = 'none';
        //         }
        //     });
        // });

        let typingTimer;
        const doneTypingInterval = 500;
        const searchInput = document.querySelector('input[name="search"]');

        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(submitSearchForm, doneTypingInterval);
        });

        function submitSearchForm() {
            const form = document.querySelector('#search-form');
            form.submit();
        }

        function moveCursorToEnd(input) {
            // Move the cursor to the end of the input value
            input.setSelectionRange(input.value.length, input.value.length);
        }
    </script>
@endsection
