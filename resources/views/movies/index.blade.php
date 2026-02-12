@extends('layouts.app')
@section('content')
<div class="mb-8 flex flex-wrap justify-center gap-2">
    <input type="text" id="search" placeholder="{{ __('msg.search') }}" 
           class="w-full md:w-1/3 p-3 rounded bg-slate-300 border border-slate-400 text-gray-700">

    <select id="filter-type" class="p-3 rounded bg-slate-300 border border-slate-400 text-gray-700">
        <option value="">{{ __('msg.all_types') }}</option>
        <option value="movie">Movie</option>
        <option value="series">Series</option>
    </select>

    <input type="number" id="filter-year" placeholder="(e.g. 2024)" 
           class="w-24 md:w-32 p-3 rounded bg-slate-300 border border-slate-400 text-gray-700"
           min="1900" max="2026">

    <button onclick="searchMovies()" class="bg-slate-500 text-white px-6 py-3 rounded font-bold hover:bg-slate-600">
        {{ __('msg.search_btn') }}
    </button>
</div>

<div id="movie-list" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
    </div>

<div id="loading" class="hidden text-center py-10">
    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-yellow-500"></div>
    <p class="text-gray-600 mt-2">Loading more movies...</p>
</div>

<script>
    window.aldmicMovie = {
        apiKey: "{{ $apiKey }}",
        favoriteIds: @json($favoriteIds ?? []),
        urlAddFavorite: "{{ url('/favorites') }}",
        csrfToken: "{{ csrf_token() }}",
        msg: {
            favorited: "{{ __('msg.favorited') }}",
            addFavorite: "{{ __('msg.add_favorite') }}",
            success: "{{ __('msg.success_alert') }}",
            fail: "{{ __('msg.fail_alert') }}",
            notFound: "{{ __('msg.not_found') }}",
        }
    };
</script>
<script src="{{ asset('js/movie-index.js') }}" defer></script>
@endsection