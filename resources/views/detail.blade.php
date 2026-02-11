@extends('layouts.app')
@section('content')
<div class="flex flex-col md:flex-row gap-10 bg-gray-800 p-8 rounded-xl shadow-2xl">
    <img src="{{ $movie['Poster'] }}" class="w-full md:w-1/3 rounded-lg shadow-lg" loading="lazy">
    <div class="flex-1">
        <h1 class="text-4xl font-bold text-yellow-500 mb-2">{{ $movie['Title'] }}</h1>
        <p class="text-gray-400 mb-4">{{ $movie['Released'] }} | {{ $movie['Genre'] }} | {{ $movie['Runtime'] }}</p>
        <div class="mb-6">
            <h3 class="text-xl font-bold mb-2">Plot:</h3>
            <p class="text-gray-300 leading-relaxed">{{ $movie['Plot'] }}</p>
        </div>
        <p class="mb-2"><strong>Director:</strong> {{ $movie['Director'] }}</p>
        <p class="mb-6"><strong>Actors:</strong> {{ $movie['Actors'] }}</p>
        
        <button class="bg-yellow-500 text-black font-bold px-6 py-3 rounded hover:bg-yellow-600">Add to Favorite</button>
    </div>
</div>
@endsection