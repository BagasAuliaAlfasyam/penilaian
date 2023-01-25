<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::orderBy('id', 'desc')->get();

        if (request()->ajax()) {
            return datatables()->of($siswa)
                ->addColumn('jenis_kelamin', function ($siswa) {
                    if ($siswa->jenis_kelamin == 'L') {
                        $jk = 'Laki-laki';
                    } else {
                        $jk = 'Perempuan';
                    }
                    return $jk;
                })
                ->addColumn('action', function ($siswa) {
                    $button = "<a href='/siswa/edit/" . $siswa->id . "' class='btn btn-sm btn-success ms-1'>Edit</a>";
                    $button .= "<button class='btn btn-sm btn-danger ms-1 hapus-siswa' id='" . $siswa->id . "'>Hapus</button>";
                    return $button;
                })
                ->rawColumns(['jenis_kelamin', 'action'])
                ->make(true);
        }
        return view('admin.siswa.siswa');
    }

    public function add()
    {
        return view('admin.siswa.tambah');
    }

    public function store()
    {
        request()->validate([
            'nisn' => 'required|unique:siswas,nisn',
            'nama_siswa' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'jenis_kelamin' => 'required',
            'nama_wali' => 'required',
            'telepon_wali' => 'required|numeric',
            'alamat' => 'required',
        ], [
            'nisn.required' => 'NISN harus di isi',
            'nisn.unique' => 'NISN sudah terdaftar',
            'nama_siswa.required' => 'Nama siswa harus di isi',
            'jurusan.required' => 'Jurusan harus di pilih',
            'kelas.required' => 'Kelas harus di pilih',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'nama_wali.required' => 'Nama wali harus di isi',
            'telepon_wali.required' => 'Telpon wali harus di isi',
            'telepon_wali.numeric' => 'Telpon wali harus angka',
            'alamat.required' => 'Alamat harus di isi',
        ]);

        Siswa::create([
            'nisn' => strtoupper(request('nisn')),
            'nama_siswa' => ucwords(request('nama_siswa')),
            'jurusan' => request('jurusan'),
            'kelas' => request('kelas'),
            'jenis_kelamin' => request('jenis_kelamin'),
            'wali' => ucwords(request('nama_wali')),
            'telepon_wali' => request('telepon_wali'),
            'alamat' => ucwords(request('alamat')),
        ]);

        return response()->json([
            'message' => 'siswa berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);

        return view('admin.siswa.edit', [
            'siswa' => $siswa
        ]);
    }

    public function update($id)
    {
        $siswa = Siswa::find($id);

        request()->validate([
            'nisn-edit' => 'required|unique:siswas,nisn,' . $siswa->id,
            'nama-siswa-edit' => 'required',
            'nama-wali-edit' => 'required',
            'telepon_wali-edit' => 'required|numeric',
            'alamat-edit' => 'required',
        ], [
            'nisn-edit.required' => 'NISN harus di isi',
            'nisn-edit.unique' => 'NISN sudah terdaftar',
            'nama-siswa-edit.required' => 'Nama siswa harus di isi',
            'nama-wali-edit.required' => 'Nama wali harus di isi',
            'telepon_wali-edit.required' => 'Telepon wali harus di isi',
            'telepon_wali-edit.numeric' => 'Telpon wali harus angka',
            'alamat-edit.required' => 'Alamat harus di isi'
        ]);

        $siswa->update([
            'nisn' => strtoupper(request('nisn-edit')),
            'nama_siswa' => ucwords(request('nama-siswa-edit')),
            'kelas' => request('kelas-edit'),
            'jenis_kelamin' => request('jenis_kelamin-edit'),
            'wali' => ucwords(request('nama-wali-edit')),
            'telepon_wali' => request('telepon_wali-edit'),
            'alamat' => ucwords(request('alamat-edit')),
        ]);

        return response()->json([
            'message' => 'siswa berhasil di edit'
        ]);
    }

    public function delete($id)
    {
        $siswa = Siswa::find($id);

        $siswa->delete();

        return response()->json([
            'message' => 'siswa berhasil di hapus'
        ]);
    }
}
