@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Explore Users</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <form action="{{ route('profile.search') }}" method="GET" id="search-form">
                        <input type="text" name="search" value="{{ $query }}" id="search"
                            class="form-control mb-5" autofocus placeholder="What are you looking for?" />
                    </form>

                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <a href="/user/{{ $user->name }}" class="text-decoration-none">
                                <div class="card rounded bg-white overflow-hidden p-2 mb-2">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->picture }}" alt="event" width="64px"
                                            class="rounded-circle" />
                                        <span class="text-muted ms-3 ">{{ $user->name }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="./home" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/home.png" alt="Home" />
                        </div>
                    </a>

                    <a href="./search" class="d-block col-3 h-100 p-0">
                        <div class="active w-100 h-100 d-flex justify-content-center align-items-center">
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
    </script>
@endsection
