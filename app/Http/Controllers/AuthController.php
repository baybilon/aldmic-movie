<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{

    public function showLogin()
    {

        if (Auth::check()) {
            return redirect()->route('movies.index');
        }
        return view('auth.login');
    }


    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('movies.index');
        }

        return redirect()->back()
            ->withInput($request->only('username'))
            ->withErrors(['msg' => __('msg.login_failed')]); 
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}