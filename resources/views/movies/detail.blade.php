@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="javascript:void(0)" onclick="history.back()" class="text-gray-800 mb-4 hover:underline flex items-center gap-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>{{ __('msg.back') }}</span>
    </a>

    <div class="flex flex-col md:flex-row gap-8 bg-slate-50 p-6 rounded-lg shadow-xl">
        <div class="w-full md:w-1/3">
            @php
                $placeholder = "https://placehold.co/400x600?text=No+Poster";
                $posterUrl = ($movie['Poster'] !== 'N/A' && !empty($movie['Poster'])) ? $movie['Poster'] : $placeholder;
            @endphp

            <img src="{{ $posterUrl }}" 
                alt="{{ $movie['Title'] }}"
                class="w-full rounded-lg shadow-lg border border-slate-300"
                onerror="this.onerror=null;this.src='{{ $placeholder }}';">
        </div>

        <div class="w-full md:w-2/3 text-black">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $movie['Title'] }}</h1>
            <p class="text-gray-600 mb-4">{{ $movie['Year'] }} | {{ $movie['Genre'] }} | {{ $movie['Runtime'] }}</p>
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2 text-gray-500 italic">"{{ $movie['Plot'] }}"</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p><span class="text-black uppercase">Director :</span> {{ $movie['Director'] }}</p>
                    <p><span class="text-black uppercase">Actors :</span> {{ $movie['Actors'] }}</p>
                </div>
                <div>
                    <p><span class="text-black uppercase">Rating :</span> <span class="text-amber-500 font-bold">{{ $movie['imdbRating'] }} / 10</span></p>
                    <p><span class="text-black uppercase">Awards :</span> {{ $movie['Awards'] }}</p>
                </div>
            </div>

            @if($isFavorite)
                <button class="mt-8 bg-slate-200 text-slate-500  px-6 py-3 rounded-md font-bold cursor-not-allowed" disabled>
                    {{ __('msg.favorited') }}
                </button>
            @else
                <button onclick="addToFavorite()" 
                    class="mt-8 border border-slate-500 text-slate-500 px-6 py-3 rounded-md font-bold 
                        hover:bg-slate-500 hover:text-white transition 
                        flex items-center justify-center gap-2 mx-auto md:mx-0">
                    
                    <i data-lucide="plus" class="w-5 h-5"></i> 
                    <span>{{ __('msg.add_favorite') }}</span>

                </button>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.aldmicMovie = {
        imdbID: "{{ $movie['imdbID'] }}",
        urlAddFavorite: "{{ url('/favorites') }}",
        csrfToken: "{{ csrf_token() }}",
        msg: {
            success: "{{ __('msg.success_alert') }}",
            fail: "{{ __('msg.fail_alert') }}",
            favorited: "{{ __('msg.favorited') }}"
        }
    };
</script>

{{-- Gunakan tanda tanya v= agar browser tidak pakai cache lama --}}
<script src="{{ asset('js/movie-detail.js') }}?v={{ time() }}"></script>
@endsection