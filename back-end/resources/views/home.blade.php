@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Events</h4>
            </div>
            <a href="./create" class="col-2 pe-5 h-100 d-flex justify-content-center align-items-center">
                <img src="./imgs/plus.png" alt="Events" />
            </a>
        </div>
    </div>
    <div class="content h-84 py-4">
        <div class="container">
            @if (session()->has('message'))
                <div class="alert alert-{{ session('type') }}" role="alert"> {{ session('message') }} </div>
            @endif
            <input type="text" name="search" id="search" class="form-control mb-5" autofocus
                placeholder="What are you looking for?" />

            <div class="row">
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
@section('scripts')
    <script>
        const searchBox = document.getElementById('search');
        const listItems = document.querySelectorAll('.category');
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
