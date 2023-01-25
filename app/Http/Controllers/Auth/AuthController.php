<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('layout.auth');
    }

    public function store()
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password min 6 karakter'
        ]);

        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard');
            } elseif (Auth::user()->role == 'guru') {
                return redirect('/penilaian');
            } elseif (Auth::user()->role == 'wali_kelas') {
                return redirect('/kelasku');
            } else {
                return redirect('/');
            }
        }

        return redirect('/')->with('message', 'Username dan Password tidak sesuai');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/')->with('logout', 'Anda telah keluar');
    }
}
