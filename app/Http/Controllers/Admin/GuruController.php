<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::orderBy('id', 'desc')->get();

        if (request()->ajax()) {
            return datatables()->of($guru)
                ->addColumn('username', function ($guru) {
                    return $guru->user->username;
                })
                ->addColumn('email', function ($guru) {
                    return $guru->user->email;
                })
                ->addColumn('jenis_kelamin', function ($guru) {
                    if ($guru->jenis_kelamin == 'L') {
                        $jk = 'Laki-laki';
                    } else {
                        $jk = 'Perempuan';
                    }
                    return $jk;
                })
                ->addColumn('action', function ($guru) {
                    $button = "<a href='/guru/edit/" . $guru->id . "' class='btn btn-sm btn-success ms-1'>Edit</a>";
                    $button .= "<button class='btn btn-sm btn-danger ms-1 hapus-guru' id='" . $guru->id . "'>Hapus</button>";
                    return $button;
                })
                ->rawColumns(['username', 'email', 'jenis_kelamin', 'action'])
                ->make(true);
        }

        return view('admin.guru.guru');
    }

    public function add()
    {
        return view('admin.guru.tambah');
    }

    public function store()
    {
        request()->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required',
            'telepon' => 'required|numeric',
            'alamat' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'konfirmasi_password' => 'same:password'
        ], [
            'nip.required' => 'NIP harus di isi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama.required' => 'Nama harus di isi',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'telepon.required' => 'Telepon harus di isi',
            'telepon.numeric' => 'Telepon harus angka',
            'alamat.required' => 'Alamat harus di isi',
            'username.required' => 'Username harus di isi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 6 karakter',
            'konfirmasi_password.same' => 'Konfirmasi password salah'
        ]);

        $user = User::create([
            'name' => ucwords(request('nama')),
            'email' => request('email'),
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'role' => 'guru'
        ]);

        Guru::create([
            'nip' => strtoupper(request('nip')),
            'user_id' => $user->id,
            'nama_guru' => $user->name,
            'jenis_kelamin' => request('jenis_kelamin'),
            'telepon' => request('telepon'),
            'alamat' => ucwords(request('alamat')),
        ]);

        return response()->json([
            'message' => 'guru berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $guru = Guru::find($id);

        $data = [
            'id' => $guru->id,
            'nip' => $guru->nip,
            'user_id' => $guru->user_id,
            'nama_guru' => $guru->nama_guru,
            'email' => $guru->user->email,
            'jenis_kelamin' => $guru->jenis_kelamin,
            'telepon' => $guru->telepon,
            'alamat' => $guru->alamat,
            'username' => $guru->user->username,
        ];

        return view('admin.guru.edit', [
            'data' => $data
        ]);
    }

    public function update($id)
    {
        // ambil guru
        $guru = Guru::find($id);

        // ambil user nya
        $user = User::find($guru->user->id);

        // validasi
        request()->validate([
            'nip-edit' => 'required|unique:gurus,nip,' . $guru->id,
            'nama-edit' => 'required',
            'email-edit' => 'required|email|unique:users,email,' . $user->id,
            'jenis_kelamin-edit' => 'required',
            'telepon-edit' => 'required|numeric',
            'alamat-edit' => 'required',
            'username-edit' => 'required|unique:users,username,' . $user->id,
        ], [
            'nip-edit.required' => 'NIP harus di isi',
            'nip-edit.unique' => 'NIP sudah terdaftar',
            'nama-edit.required' => 'Nama harus di isi',
            'email-edit.required' => 'Email harus di isi',
            'email-edit.email' => 'Email tidak valid',
            'email-edit.unique' => 'Email sudah terdaftar',
            'jenis_kelamin-edit.required' => 'Jenis kelamin harus dipilih',
            'telepon-edit.required' => 'Telepon harus di isi',
            'telepon-edit.numeric' => 'Telepon harus angka',
            'alamat-edit.required' => 'Alamat harus di isi',
            'username-edit.required' => 'Username harus di isi',
            'username-edit.unique' => 'Username sudah terdaftar'
        ]);

        // edit user nya
        $user->update([
            'name' => ucwords(request('nama-edit')),
            'email' => request('email-edit'),
            'username' => request('username-edit'),
        ]);

        // edit guru nya
        $guru->update([
            'nip' => strtoupper(request('nip-edit')),
            'nama_guru' => ucwords(request('nama-edit')),
            'jenis_kelamin' => request('jenis_kelamin-edit'),
            'telepon' => request('telepon-edit'),
            'alamat' => ucwords(request('alamat-edit')),
        ]);

        return response()->json([
            'message' => 'guru berhasil diedit',
            'guru' => $user
        ]);
    }

    public function delete($id)
    {
        $guru = Guru::find($id);
        $user = User::find($guru->user_id);

        $guru->delete();
        $user->delete();

        return response()->json([
            'message' => 'guru berhasil dihapus'
        ]);
    }
}
