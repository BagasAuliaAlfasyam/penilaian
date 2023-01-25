<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunPelajaran;
use App\Models\WaliKelas;

class TahunPelajaranController extends Controller
{
    public function index()
    {
        $t_pel = TahunPelajaran::orderBy('id', 'desc')->get();

        if (request()->ajax()) {
            return datatables()->of($t_pel)
                ->addColumn('semester', function ($t_pel) {
                    if ($t_pel->semester == 'genap') {
                        $badge = '<span class="badge rounded-pill bg-primary">' . $t_pel->semester . '</span>';
                    } else {
                        $badge = '<span class="badge rounded-pill bg-success">' . $t_pel->semester . '</span>';
                    }
                    return $badge;
                })
                ->addColumn('action', function ($t_pel) {
                    $button = "<button id='" . $t_pel->id . "' class='btn btn-sm btn-success ms-1 modal-edit' data-bs-toggle='modal' data-bs-target='#staticBackdropEdit'>Edit</button>";
                    $button .= "<a href='/tahun_pelajaran/" . $t_pel->id . "/mapel_guru' class='btn btn-sm btn-info ms-1' id='" . $t_pel->id . "'>Mapel Guru</a>";
                    return $button;
                })
                ->rawColumns(['semester', 'action'])
                ->make(true);
        }
        return view('admin.tahun_pelajaran.tahun_pelajaran');
    }

    public function store()
    {
        request()->validate([
            'tahun_pelajaran' => 'required',
            'semester' => 'required'
        ], [
            'tahun_pelajaran.required' => 'Tahun pelajaran harus di isi',
            'semester.required' => 'Semester harus dipilih'
        ]);

        $thn_pelajaran = TahunPelajaran::where('tahun_pelajaran', request('tahun_pelajaran'))
            ->where('semester', request('semester'))->first();
        if ($thn_pelajaran) {
            return response()->json([
                'duplikat' => 'Tahun pelajaran dan semester ini sudah terdaftar'
            ]);
        } else {
            TahunPelajaran::create([
                'tahun_pelajaran' => request('tahun_pelajaran'),
                'semester' => request('semester')
            ]);

            return response()->json([
                'message' => 'tahun pelajaran berhasil ditambahkan'
            ]);
        }
    }

    public function edit($id)
    {
        $t_pel = TahunPelajaran::find($id);

        return response()->json([
            'data' => $t_pel
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'tahun_pelajaran_edit' => 'required'
        ], [
            'tahun_pelajaran_edit.required' => 'Tahun pelajaran harus di isi'
        ]);

        $t_pel = TahunPelajaran::find($id);
        $thn_pelajaran = TahunPelajaran::where('tahun_pelajaran', request('tahun_pelajaran_edit'))
            ->where('semester', request('semester_edit'))->get();

        if (
            request('tahun_pelajaran_edit') !== request('tahun_pelajaran_old') && count($thn_pelajaran) > 0
            || request('semester_edit') !== request('semester_old') && count($thn_pelajaran) > 0
        ) {
            return response()->json([
                'duplikat' => 'Tahun pelajaran dan semester ini sudah terdaftar'
            ]);
        } else {
            // update tahun pelajaran
            $t_pel->update([
                'tahun_pelajaran' => request('tahun_pelajaran_edit'),
                'semester' => request('semester_edit')
            ]);

            // update table wali kelas yang tahun pelajaran dan semester nya sama dengan data old dari request
            $wali_kelas = WaliKelas::where('tahun_pelajaran', request('tahun_pelajaran_old'))
                ->where('semester', request('semester_old'))
                ->get();

            // update semua nya
            for ($i = 0; $i < count($wali_kelas); $i++) {
                $wali_kelas[$i]->update([
                    'tahun_pelajaran' => request('tahun_pelajaran_edit'),
                    'semester' => request('semester_edit')
                ]);
            }

            return response()->json([
                'message' => 'tahun pelajaran berhasil diedit'
            ]);
        }
    }
}
