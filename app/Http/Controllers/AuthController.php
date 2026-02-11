<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        // Jika sudah login, langsung lempar ke halaman movies
        if (Auth::check()) {
            return redirect()->route('movies.index');
        }
        return view('auth.login');
    }

    /**
     * Memproses data login
     */
    public function login(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // Mencoba login
        if (Auth::attempt($credentials)) {
            // Jika berhasil
            return redirect()->route('movies.index');
        }

        // Jika gagal, kembali ke login dengan pesan kesalahan
        return redirect()->back()
            ->withInput($request->only('username'))
            ->withErrors(['msg' => 'Username atau Password salah!']);
    }

    /**
     * Proses Logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}