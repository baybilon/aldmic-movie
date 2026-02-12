@extends('layouts.app')
@section('content')
<h2 class="text-3xl font-bold mb-6">Favorite Movies</h2>
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
    @foreach($favorites as $fav)
        <div class="relative bg-slate-50 rounded-lg overflow-hidden shadow-lg border border-slate-100 flex flex-col h-full">
                <div class="relative block w-full bg-black flex items-center justify-center overflow-hidden" style="aspect-ratio: 2/3;">
                    <div class="absolute top-2 left-2 z-20">
                        <span class="bg-black/60 backdrop-blur-md text-white text-[9px] md:text-[10px] uppercase px-2 py-1 rounded font-bold tracking-wider">
                            {{$fav->Type}}
                        </span>
                    </div>
                    @php
                        $posterUrl = (isset($fav->Poster) && $fav->Poster !== 'N/A') ? $fav->Poster : 'https://placehold.co/400x600?text=No+Poster';
                    @endphp
                    
                    <img src="{{ $posterUrl }}" 
                        alt="{{ $fav->Title }}"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                        onerror="this.onerror=null;this.src='https://placehold.co/400x600?text=No+Poster';">
                </div>
                <div class="p-4 flex flex-col flex-grow">
              
                <h3 class="font-bold text-gray-800 text-xs md:text-sm line-clamp-2 h-8 md:h-10 leading-tight mb-1">
                    <a href="{{ url('/movies/' . $fav->imdbID) }}" class="hover:underline">
                        {{ $fav->Title }}
                    </a>
                </h3>
                <p class="text-gray-600 text-[10px] md:text-xs mb-4">{{ $fav->Year }}</p>

                <div class="mt-auto">
                    <form action="{{ route('favorites.delete', $fav->imdbID) }}" method="POST" onsubmit="return confirm('Remove from favorites?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full border border-red-500 text-red-500 py-2 rounded hover:bg-red-500 hover:text-white font-bold text-[10px] md:text-xs transition flex items-center justify-center gap-2">
                            <i data-lucide="trash-2" class="w-3 h-3 md:w-4 h-4"></i>
                            {{ __('msg.remove') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection {{-- Selesai section content --}}

@section('scripts')
<script>
    window.aldmicMovie = {
        csrfToken: "{{ csrf_token() }}"
    };
</script>

@endsection