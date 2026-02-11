<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client; // Import Guzzle
use App\Favorite;
use Auth;

class MovieController extends Controller
{
    private $apiKey;

    public function __construct() {
        $this->apiKey = config('services.omdb.key');
    }

    public function index() {
        return view('movies.index', ['apiKey' => $this->apiKey]);
    }

    public function detail($id) {
        $client = new Client();
        $response = $client->get("http://www.omdbapi.com/?apikey={$this->apiKey}&i={$id}");
        $movie = json_decode($response->getBody(), true);

        return view('movies.detail', compact('movie'));
    }

    public function addFavorite(Request $request) {
        Favorite::updateOrCreate(
            ['imdbID' => $request->imdbID],
            [
                'title' => $request->title,
                'poster' => $request->poster
            ]
        );
        return response()->json(['message' => 'Added to favorites!']);
    }

    public function favorites() {
        $favorites = Favorite::all();
        return view('movies.favorites', compact('favorites'));
    }

    public function deleteFavorite($id) {
        Favorite::where('imdbID', $id)->delete();
        return back()->with('success', 'Movie removed from favorites');
    }
}