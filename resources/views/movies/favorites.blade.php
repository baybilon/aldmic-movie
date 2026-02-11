@extends('layouts.app')
@section('content')
<h2 class="text-3xl font-bold mb-6">Favorite Movies</h2>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
    @foreach($favorites as $fav)
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
        <img src="{{ $fav->poster }}" class="w-full h-64 object-cover" loading="lazy">
        <div class="p-4">
            <h3 class="font-bold truncate text-yellow-500">{{ $fav->title }}</h3>
            <a href="{{ route('movies.detail', $fav->imdbID) }}" class="text-xs text-blue-400 block mb-3">View Detail</a>
            
            <form action="{{ url('/favorites/'.$fav->imdbID) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs py-2 rounded transition">
                    Remove
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection