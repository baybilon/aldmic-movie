<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use Auth;

class FavoriteController extends Controller
{
    public function index() {
        $favoriteRecords = Favorite::where('user_id', auth()->id())->get();
        
        $favorites = [];
        $apiKey = env('OMDB_API_KEY');

        if (!$apiKey) {
            return "Error: OMDB_API_KEY belum diatur di file .env";
        }

        foreach ($favoriteRecords as $record) {
            $url = "http://www.omdbapi.com/?apikey={$apiKey}&i={$record->imdbID}";
            
            try {
                $response = @file_get_contents($url);
                if ($response === false) continue; 

                $movieData = json_decode($response);

                if ($movieData && isset($movieData->Response) && $movieData->Response === "True") {
                    $movieData->imdbID = $record->imdbID; 
                    $favorites[] = $movieData;
                }
            } catch (\Exception $e) {
                continue; 
            }
        }

        return view('movies.favorites', compact('favorites'));
    }

    public function store(Request $request) {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error', 
                'message' => __('msg.session_expired') 
            ], 401);
        }

        try {
            $userId = Auth::user()->id; 

            Favorite::updateOrCreate([
                'user_id' => $userId, 
                'imdbID'  => $request->imdbID
            ]);

            return response()->json([
                'status' => 'success',
                'message' => __('msg.success_alert')
            ]);
        } 
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => __('msg.fail_alert')
            ], 500);
        }
    }

    public function destroy($imdbID) {
        Favorite::where('user_id', auth()->id())
                ->where('imdbID', $imdbID)
                ->delete();
        return back()->with('success', __('msg.success_alert')); 
    }
}