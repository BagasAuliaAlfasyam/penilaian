<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapelGuru;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelGuruController extends Controller
{
    public function index($id)
    {
        $data = TahunPelajaran::find($id);
        $guru = Guru::orderBy('nama_guru', 'asc')->get();
        $mapel = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')
            ->get();

        $mapelGuru = MapelGuru::where('tahun_pelajaran_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        if (request()->ajax()) {
            return datatables()->of($mapelGuru)
                ->addColumn('guru', function ($mapelGuru) {
                    return $mapelGuru->guru->nama_guru;
                })
                ->addColumn('mapel', function ($mapelGuru) {
                    return $mapelGuru->mapel->nama_mata_pelajaran;
                })
                ->addColumn('status', function ($mapelGuru) {
                    if ($mapelGuru->status == 0) {
                        $status = '<span class="badge bg-warning rounded-pill">Pending</span>';
                    } else {
                        $status = '<span class="badge bg-success rounded-pill">Berlangsung</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($mapelGuru) {
                    $button = '<a href="/tahun_pelajaran/' . $mapelGuru->tahun_pelajaran_id . '/mapel_guru/' . $mapelGuru->id . '/detail" class="btn btn-sm btn-info ms-1">Detail</a>';
                    $button .= '<button class="btn btn-sm btn-success ms-1 edit-mapel-guru" data-bs-toggle="modal" data-bs-target="#staticBackdropEdit" id="' . $mapelGuru->id . '" thn_pel_id="' . $mapelGuru->tahun_pelajaran_id . '">Edit</button>';
                    if ($mapelGuru->status == 0) {
                        $button .= "<button class='btn btn-sm btn-primary ms-1 publish-mapel-guru' id_thn_pelajaran='" . $mapelGuru->tahun_pelajaran_id . "' id_mapel_guru='" . $mapelGuru->id . "'>Publish</button>";
                        $button .= "<button class='btn btn-sm btn-danger ms-1 hapus-mapel-guru' id_thn_pelajaran='" . $mapelGuru->tahun_pelajaran_id . "' id_mapel_guru='" . $mapelGuru->id . "'>Hapus</button>";
                    }
                    return $button;
                })
                ->rawColumns(['guru', 'mapel', 'status', 'action'])
                ->make(true);
        }

        return view('admin.mapel_guru.mapel_guru', [
            'data' => $data,
            'guru' => $guru,
            'mapel' => $mapel
        ]);
    }

    public function store()
    {
        request()->validate([
            'guru' => 'required',
            'mapel' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required'
        ], [
            'guru.required' => 'Guru harus dipilih',
            'mapel.required' => 'Mata pelajaran harus dipilih',
            'jurusan.required' => 'Jurusan harus dipilih',
            'kelas.required' => 'Kelas harus dipilih',
        ]);

        $cekDuplikat = MapelGuru::where('tahun_pelajaran_id', request('tahun_pelajaran_id'))
            ->where('guru_id', request('guru'))
            ->where('mapel_id', request('mapel'))
            ->where('jurusan', request('jurusan'))
            ->where('kelas', request('kelas'))
            ->get();

        if (count($cekDuplikat) > 0) {
            return response()->json([
                'duplikat' => 'Guru, Mapel, Jurusan dan kelas ini sudah terdaftar'
            ]);
        } else {
            $cekSiswa = Siswa::
            where('jurusan', request('jurusan'))
            ->where('kelas', request('kelas'))
            ->get();
            if (count($cekSiswa) <= 0) {
                return response()->json([
                    'duplikat' => 'Siswa di kelas ini masih kosong, silahkan input data siswa !'
                ]);
            } else {
                $cekDuplikat2 = MapelGuru::where('tahun_pelajaran_id', request('tahun_pelajaran_id'))
                    ->where('mapel_id', request('mapel'))
                    ->where('jurusan', request('jurusan'))
                    ->where('kelas', request('kelas'))
                    ->get();

                if (count($cekDuplikat2) > 0) {
                    return response()->json([
                        'duplikat' => 'Mapel dan kelas ini sudah terdaftar'
                    ]);
                } else {
                    $mapelGuru = MapelGuru::create([
                        'tahun_pelajaran_id' => request('tahun_pelajaran_id'),
                        'guru_id' => request('guru'),
                        'mapel_id' => request('mapel'),
                        'jurusan' => request('jurusan'),
                        'kelas' => request('kelas')
                    ]);

                    $siswa = Siswa::
                    where('jurusan', request('jurusan'))
                    ->where('kelas', request('kelas'))
                    ->get();

                    for ($i = 0; $i < count($siswa); $i++) {
                        Nilai::create([
                            'tahun_pelajaran_id' => request('tahun_pelajaran_id'),
                            'mapel_guru_id' => $mapelGuru->id,
                            'siswa_id' => $siswa[$i]->id
                        ]);
                    }

                    return response()->json([
                        'message' => 'mapel guru berhasil ditambahkan'
                    ]);
                }
            }
        }
    }

    public function edit($tp_id, $id)
    {
        $mapelGuru = MapelGuru::find($id);

        return response()->json([
            'data' => $mapelGuru
        ]);
    }

    public function update($tp_id, $id)
    {
        $mapelGuru = MapelGuru::find($id);

        $cekDuplikat = MapelGuru::where('tahun_pelajaran_id', request('id_thn_pel_edit'))
            ->where('guru_id', request('guru-edit'))
            ->where('mapel_id', request('mapel-edit'))
            ->where('jurusan', request('jurusan-edit'))
            ->where('kelas', request('kelas-edit'))
            ->get();

        if (request('guru-edit') !== request('guru-edit-old') && count($cekDuplikat) > 0 || request('mapel-edit') !== request('mapel-edit-old') && count($cekDuplikat) > 0 || request('kelas-edit') !== request('kelas-edit-old') && count($cekDuplikat) > 0) {

            return response()->json([
                'duplikat' => 'Guru, mapel dan kelas ini sudah terdaftar'
            ]);
        } else {

            $cekDuplikat2 = MapelGuru::where('tahun_pelajaran_id', request('id_thn_pel_edit'))
                ->where('mapel_id', request('mapel-edit'))
                ->where('jurusan', request('jurusan-edit'))
                ->where('kelas', request('kelas-edit'))
                ->get();
            if (request('mapel-edit') !== request('mapel-edit-old') && count($cekDuplikat2) > 0 || request('kelas-edit') !== request('kelas-edit-old') && count($cekDuplikat2) > 0) {
                return response()->json([
                    'duplikat' => 'Mapel dan kelas ini sudah terdaftar'
                ]);
            } else {
                $mapelGuru->update([
                    'guru_id' => request('guru-edit'),
                    'mapel_id' => request('mapel-edit')
                ]);

                return response()->json([
                    'message' => 'mapel guru berhasil diedit'
                ]);
            }
        }
    }

    public function publish($tp_id, $id)
    {
        $mp_guru = MapelGuru::find($id);
        $updated = $mp_guru->update([
            'status' => 1
        ]);

        return response()->json([
            'message' => 'mapel guru berhasil di publish'
        ]);
    }

    public function delete($tp_id, $id)
    {
        $nilai = Nilai::where('tahun_pelajaran_id', $tp_id)
            ->where('mapel_guru_id', $id);
        $nilai->delete();

        $mp_guru = MapelGuru::find($id);
        $mp_guru->delete();

        return response()->json([
            'message' => 'siswa di table nilai berhasil dihapus, mapel guru berhasil dihapus'
        ]);
    }
}
