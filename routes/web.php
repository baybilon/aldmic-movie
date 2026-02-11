<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'AuthController@showLogin')->name('login');
Route::post('/login', 'AuthController@login');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

Route::group(['middleware' => 'checkAuth'], function () {
    Route::get('/movies', 'MovieController@index')->name('movies.index');
    Route::get('/movies/{id}', 'MovieController@detail')->name('movies.detail');
    Route::get('/favorites', 'MovieController@favorites')->name('movies.favorites');
    Route::post('/favorites', 'MovieController@addFavorite');
    Route::delete('/favorites/{id}', 'MovieController@deleteFavorite');
    Route::get('/logout', 'AuthController@logout');
});

