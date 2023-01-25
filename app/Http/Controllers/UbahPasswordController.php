<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UbahPasswordController extends Controller
{
    public function index()
    {
        return view('ubah_password');
    }

    public function ubah_password()
    {
        request()->validate([
            'password' => 'required|min:6',
            'konfirmasi_password' => 'same:password'
        ],[
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 6 karakter',
            'konfirmasi_password.same' => 'Konfirmasi password salah'
        ]);

        $user = User::find(Auth::user()->id);
        $user->update([
            'password' => bcrypt(request('password'))
        ]);

        return response()->json([
            'message' => 'Password berhasil di ubah'
        ]);
    }
}
