<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapelGuru;
use App\Models\Nilai;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index($tp_id, $id)
    {
        $thn_pelajaran = TahunPelajaran::find($tp_id);
        $mapel_guru = MapelGuru::find($id);

        $nilai = Nilai::where('tahun_pelajaran_id', $tp_id)
            ->where('mapel_guru_id', $id)
            ->get();
        if (request()->ajax()) {
            return datatables()->of($nilai)
                ->addColumn('siswa', function ($nilai) {
                    return $nilai->siswa->nama_siswa;
                })
                ->addColumn('action', function ($nilai) {
                    $button = '<button class="btn btn-sm btn-success ms-1 edit-nilai" data-bs-toggle="modal" data-bs-target="#staticBackdropEdit" id_nilai="' . $nilai->id . '" id_thn_pelajaran="' . $nilai->tahun_pelajaran_id . '" id_mapel_guru="' . $nilai->mapel_guru_id . '">Edit</button>';
                    return $button;
                })
                ->rawColumns(['siswa', 'action'])
                ->make(true);
        }

        return view('admin.mapel_guru.detail', [
            'thn_pelajaran' => $thn_pelajaran,
            'mapel_guru' => $mapel_guru
        ]);
    }

    public function edit($id_tp, $id_mp_ust, $id_nilai)
    {
        $nilai = Nilai::find($id_nilai);

        return response()->json([
            'data' => $nilai
        ]);
    }

    public function update($id_tp, $id_mp_ust, $id_nilai)
    {
        if (
            request('n1') == 0 &&
            request('n2') == 0 &&
            request('n3') == 0 &&
            request('n4') == 0 &&
            request('n5') == 0 &&
            request('n6') == 0 &&
            request('uas') == 0
        ) {
            return response()->json([
                'error' => 'Semua kolom tidak boleh 0'
            ]);
        } else {

            $nilai = Nilai::find($id_nilai);
            $nilai->update([
                'n1' => request('n1'),
                'n2' => request('n2'),
                'n3' => request('n3'),
                'n4' => request('n4'),
                'n5' => request('n5'),
                'n6' => request('n6'),
                'uas' => request('uas'),
            ]);

            $rata2 = Nilai::find($id_nilai); //rata rata nilai sama dengan temukan model nilai melalui id nilai
            $n1 = $rata2->n1 !== 0 ? 1 : 0; //deklarasi variabel nilai 1 sampai 6
            $n2 = $rata2->n2 !== 0 ? 1 : 0;
            $n3 = $rata2->n3 !== 0 ? 1 : 0;
            $n4 = $rata2->n4 !== 0 ? 1 : 0;
            $n5 = $rata2->n5 !== 0 ? 1 : 0;
            $n6 = $rata2->n6 !== 0 ? 1 : 0;
            $rata2->update([ // metod update rata rata dengan hasil nilai 1 sampai 6 di tambah dan di bagi 6 (karna ada 6 nilai)
                'rata_rata_n' => ($rata2->n1 + $rata2->n2 + $rata2->n3 + $rata2->n4 + $rata2->n5 + $rata2->n6) / ($n1 + $n2 + $n3 + $n4 + $n5 + $n6)
            ]);

            $nilai_akhir = Nilai::find($id_nilai); //variabel nilai akhir sama dengan temukan model nilai melalui id nilai
            if ($nilai_akhir->uas !== 0) { //jika nilai uas to
                $nilai_akhir->update([
                    'nilai_akhir' => ($nilai_akhir->uas + $nilai_akhir->rata_rata_n) / 2
                ]);
            }

            return response()->json([
                'message' => 'nilai berhasil diupdate'
            ]);
        }
    }
}
