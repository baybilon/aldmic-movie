@extends('layouts.app')
@section('content')
<div class="mb-8 flex justify-center">
    <input type="text" id="search" placeholder="Search movies..." placeholder="{{ __('msg.search') }}" class="w-1/2 p-3 rounded-l bg-gray-800 border border-gray-700">
    <button onclick="searchMovies()" class="bg-yellow-500 text-black px-6 rounded-r font-bold">Search</button>
</div>

<div id="movie-list" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
    
</div>

<div id="loading" class="text-center py-10 hidden">Loading more movies...</div>

<script>
    let page = 1;
    let query = 'Marvel';
    let loading = false;

    const apiKey = "{{ $apiKey }}";

    function fetchMovies(append = false) {
        if(loading) return;
        loading = true;
        document.getElementById('loading').classList.remove('hidden');

        fetch(`https://www.omdbapi.com/?apikey=${apiKey}&page=${page}&s=`)
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('movie-list');
                if(!append) list.innerHTML = '';
                
                if(data.Search) {
                    data.Search.forEach(movie => {
                        list.innerHTML += `
                            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition">
                                <a href="/movies/${movie.imdbID}">
                                    <img src="${movie.Poster}" loading="lazy" class="w-full h-64 object-cover" alt="${movie.Title}">
                                    <div class="p-4">
                                        <h3 class="font-bold truncate">${movie.Title}</h3>
                                        <p class="text-gray-400 text-sm">${movie.Year}</p>
                                    </div>
                                </a>
                                <button onclick="addToFav('${movie.imdbID}', '${movie.Title}', '${movie.Poster}')" class="w-full bg-gray-700 py-1 text-xs hover:bg-yellow-500 hover:text-black">♥ Add Favorite</button>
                            </div>
                        `;
                    });
                }
                loading = false;
                document.getElementById('loading').classList.add('hidden');
            });
    }

    window.onscroll = function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
            page++;
            fetchMovies(true);
        }
    };

    function searchMovies() {
        query = document.getElementById('search').value;
        page = 1;
        fetchMovies(false);
    }

    fetchMovies();
</script>
@endsection