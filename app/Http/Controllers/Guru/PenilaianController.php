<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MapelGuru;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();
        $mapel_guru = MapelGuru::where('guru_id', $guru->id)
            ->where('status', 1)
            ->get();

        if (request()->ajax()) {
            return datatables()->of($mapel_guru)
                ->addColumn('tahun_pelajaran', function ($mapel_guru) {
                    return $mapel_guru->tahun_pelajaran->tahun_pelajaran;
                })
                ->addColumn('semester', function ($mapel_guru) {
                    if ($mapel_guru->tahun_pelajaran->semester == 'genap') {
                        $badge = '<span class="badge rounded-pill bg-primary">' . $mapel_guru->tahun_pelajaran->semester . '</span>';
                    } else {
                        $badge = '<span class="badge rounded-pill bg-success">' . $mapel_guru->tahun_pelajaran->semester . '</span>';
                    }
                    return $badge;
                })
                ->addColumn('mapel', function ($mapel_guru) {
                    return $mapel_guru->mapel->nama_mata_pelajaran;
                })
                ->addColumn('action', function ($mapel_guru) {
                    $button = "<a href='/penilaian/tahun_pelajaran_id/" . $mapel_guru->tahun_pelajaran_id . "/mapel_guru_id/" . $mapel_guru->id . "/nilai_siswa' class='btn btn-sm btn-info ms-1'>Nilai Siswa</a>";
                    return $button;
                })
                ->rawColumns(['tahun_pelajaran', 'semester', 'mapel', 'action'])
                ->make(true);
        }

        return view('guru.penilaian');
    }
}
