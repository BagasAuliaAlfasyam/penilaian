<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
 
class MataPelajaranController extends Controller
{
    public function index()
    {  
        return view('admin.mata_pelajaran.mata_pelajaran');
    }

    public function ambilData()
    {
        $mapel = MataPelajaran::orderBy('id','desc')->get();

        return response()->json([
            'mapel' => $mapel
        ]);
    }

    public function show($id)
    {
        $mapel = MataPelajaran::find($id);

        return response()->json([
            'mapel' => $mapel
        ]);
    }

    public function store()
    {
        request()->validate([
            'kode' => 'required|unique:mata_pelajarans,kode',
            'nama_mata_pelajaran' => 'required|unique:mata_pelajarans,nama_mata_pelajaran'
        ],[
            'kode.required' => 'Kode harus di isi',
            'kode.unique' => 'Kode sudah terdaftar',
            'nama_mata_pelajaran.required' => 'Nama mata pelajaran harus di isi',
            'nama_mata_pelajaran.unique' => 'Nama mata pelajaran sudah terdaftar'
        ]);

        MataPelajaran::create([
            'kode' => strtoupper(request('kode')),
            'nama_mata_pelajaran' => ucwords(request('nama_mata_pelajaran'))
        ]);

        return response()->json([
            'message' => 'mata pelajaran berhasil ditambahkan'
        ]);
    }

    public function update($id)
    {
        $mapel = MataPelajaran::find($id);

        request()->validate([
            'kode_edit' => 'required|unique:mata_pelajarans,kode,'.$mapel->id,
            'nama_mata_pelajaran_edit' => 'required|unique:mata_pelajarans,nama_mata_pelajaran,'.$mapel->id
        ],[
            'kode_edit.required' => 'Kode harus di isi',
            'kode_edit.unique' => 'Kode sudah terdaftar',
            'nama_mata_pelajaran_edit.required' => 'Nama mata pelajaran harus di isi',
            'nama_mata_pelajaran_edit.unique' => 'Nama mata pelajaran sudah terdaftar'
        ]);

        $mapel->update([
            'kode' => strtoupper(request('kode_edit')),
            'nama_mata_pelajaran' => ucwords(request('nama_mata_pelajaran_edit'))
        ]);

        return response()->json([
            'message' => 'mata pelajaran berhasil diedit'
        ]);
    }

    public function delete($id)
    {
        $mapel = MataPelajaran::find($id);

        $mapel->delete();

        return response()->json([
            'message' => 'mata pelajaran berhasil dihapus'
        ]);
    }
}