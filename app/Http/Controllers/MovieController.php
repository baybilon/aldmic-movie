<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Favorite;
use Auth;

class MovieController extends Controller{
    private $apiKey;

    public function __construct() {
        $this->apiKey = config('services.omdb.key');
    }

    public function index() {
        $favoriteIds = \App\Favorite::pluck('imdbID')->toArray(); 

        return view('movies.index', [
                'apiKey' => $this->apiKey,
                'favoriteIds' => $favoriteIds,
                'defaultSearch' => 'Marvel'
            ]);
    }

    public function detail($id) {
        $client = new Client();
        $response = $client->get("https://www.omdbapi.com/?apikey={$this->apiKey}&i={$id}");
        $movie = json_decode($response->getBody(), true);

        $isFavorite = \App\Favorite::where('imdbID', $id)->exists();

        return view('movies.detail', compact('movie', 'isFavorite'));
    }

    public function favorites() {
        $favorites = \App\Favorite::all(); 

        return view('movies.favorites', [
            'favorites' => $favorites
        ]);
    }

}