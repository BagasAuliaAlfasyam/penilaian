<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\MapelGuru;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\Guru;
use App\Models\WaliKelas;
use App\Models\WaliKelasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelasKuController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)
            ->first();
        $wali_kelas = WaliKelas::where('guru_id', $guru->id)
            ->get();

        if (request()->ajax()) {
            return datatables()->of($wali_kelas)
                // ->addColumn('status', function($wali_kelas){
                //     return $wali_kelas->status;
                // })
                ->addColumn('action', function ($wali_kelas) {
                    $button = "<a href='/kelasku/" . $wali_kelas->id . "/siswa_client' class='btn btn-sm btn-info ms-1'>Siswa</a>";
                    return $button;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('wali_kelas.kelasku');
    }

    // siswa menggunakan datatable server side
    public function siswa($id)
    {
        $wali_kelas_siswa = WaliKelasSiswa::where('wali_kelas_id', $id)
            ->get();
        if (request()->ajax()) {
            return datatables()->of($wali_kelas_siswa)
                ->addColumn('siswa', function ($wali_kelas_siswa) {
                    return $wali_kelas_siswa->siswa->nama_siswa;
                })
                ->addColumn('kelakuan', function ($wali_kelas_siswa) {
                    if ($wali_kelas_siswa->kelakuan == null) {
                        return '<div>-</div>';
                    } else {
                        return $wali_kelas_siswa->kelakuan;
                    }
                })
                ->addColumn('kerajinan', function ($wali_kelas_siswa) {
                    if ($wali_kelas_siswa->kerajinan == null) {
                        return '<div>-</div>';
                    } else {
                        return $wali_kelas_siswa->kerajinan;
                    }
                })
                ->addColumn('kebersihan', function ($wali_kelas_siswa) {
                    if ($wali_kelas_siswa->kebersihan == null) {
                        return '<div>-</div>';
                    } else {
                        return $wali_kelas_siswa->kebersihan;
                    }
                })
                ->addColumn('action', function ($wali_kelas_siswa) {
                    $button = "<a href='/kelasku/" . $wali_kelas_siswa->wali_kelas_id . "/siswa/" . $wali_kelas_siswa->siswa_id . "/tp/" . $wali_kelas_siswa->wali_kelas->tahun_pelajaran . "/sm/" . $wali_kelas_siswa->wali_kelas->semester . "/kl/" . $wali_kelas_siswa->wali_kelas->kelas . "' class='btn btn-sm btn-info ms-1'>Nilai</a>";
                    return $button;
                })
                ->rawColumns(['kelakuan', 'kerajinan', 'kebersihan', 'siswa', 'action'])
                ->make(true);
        }

        // /kelasku/".$wali_kelas_siswa->id."/siswa
        return view('wali_kelas.siswa', [
            'route_id' => $id
        ]);
    }

    // siswa menggunakan datatable client side
    public function siswa_client($id)
    {
        $wali_kelas = WaliKelas::find($id);

        if (!$wali_kelas || Auth::user()->id !== $wali_kelas->guru->user->id) {
            return redirect('/kelasku');
        }

        return view('wali_kelas.siswa_client', [
            'route_id' => $id
        ]);
    }

    public function ambil_data($id)
    {
        $wali_kelas = WaliKelas::find($id);

        if (!$wali_kelas || Auth::user()->id !== $wali_kelas->guru->user->id) {
            return redirect('/kelasku');
        }

        $wali_kelas_siswa = WaliKelasSiswa::join('siswas', 'siswas.id', '=', 'wali_kelas_siswas.siswa_id')
            ->join('wali_kelas', 'wali_kelas.id', '=', 'wali_kelas_siswas.wali_kelas_id')
            ->where('wali_kelas_id', $wali_kelas->id)
            ->select('wali_kelas_siswas.*', 'siswas.id as siswa_id', 'siswas.nama_siswa as nama_siswa', 'wali_kelas.tahun_pelajaran as tahun_pelajaran', 'wali_kelas.semester as semester', 'wali_kelas.kelas as kelas')
            ->orderBy('wali_kelas_siswas.jumlah_nilai', 'desc')
            ->orderBy('nama_siswa', 'asc')
            ->get();

        $data = [];
        for ($i = 0; $i < count($wali_kelas_siswa); $i++) {

            // ambil data di table "tahun pelajaran" yang "tahun_pelajaran" sama dengan "$tahun_pelajaran" dan "semester" sama dengan "$semester" (ini untuk kebutuhan query nilai)
            $tahun_pelajaran = TahunPelajaran::where('tahun_pelajaran', $wali_kelas_siswa[$i]->tahun_pelajaran)
                ->where('semester', $wali_kelas_siswa[$i]->semester)
                ->first();

            // ambil data siswa
            $data_siswa = Siswa::find($wali_kelas_siswa[$i]->siswa_id);

            // ambil data nilai
            $nilai = Nilai::where('tahun_pelajaran_id', $tahun_pelajaran->id)
                ->where('siswa_id', $data_siswa->id)
                ->get();

            $nilai_akhir = 0;
            for ($j = 0; $j < count($nilai); $j++) {
                $nilai_akhir = $nilai_akhir + $nilai[$j]->nilai_akhir;
            }

            $data[] = [
                'id' => $wali_kelas_siswa[$i]->id,
                'wali_kelas_id' => $wali_kelas_siswa[$i]->wali_kelas_id,
                'siswa_id' => $wali_kelas_siswa[$i]->siswa_id,
                'nama_siswa' => $wali_kelas_siswa[$i]->nama_siswa,
                'kelakuan' => $wali_kelas_siswa[$i]->kelakuan,
                'kerajinan' => $wali_kelas_siswa[$i]->kerajinan,
                'kebersihan' => $wali_kelas_siswa[$i]->kebersihan,
                'sakit' => $wali_kelas_siswa[$i]->sakit,
                'izin' => $wali_kelas_siswa[$i]->izin,
                'alpha' => $wali_kelas_siswa[$i]->alpha,
                'catatan_wali_kelas' => $wali_kelas_siswa[$i]->catatan_wali_kelas,
                'tahun_pelajaran' => $wali_kelas_siswa[$i]->tahun_pelajaran,
                'semester' => $wali_kelas_siswa[$i]->semester,
                'kelas' => $wali_kelas_siswa[$i]->kelas,
                'nilai_akhir' => $nilai_akhir,
                'jumlah_nilai' => $wali_kelas_siswa[$i]->jumlah_nilai,
                'created_at' => $wali_kelas_siswa[$i]->created_at,
                'updated_at' => $wali_kelas_siswa[$i]->updated_at,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function data_edit($id, $wali_kelas_siswa_id, $siswa, $tahun_pelajaran, $semester)
    {
        // ambil data di table "tahun pelajaran" yang "tahun_pelajaran" sama dengan "$tahun_pelajaran" dan "semester" sama dengan "$semester" (ini untuk kebutuhan query nilai)
        $tahun_pelajaran = TahunPelajaran::where('tahun_pelajaran', $tahun_pelajaran)
            ->where('semester', $semester)
            ->first();

        // ambil data siswa
        $data_siswa = Siswa::find($siswa);

        // ambil data nilai
        $nilai = Nilai::where('tahun_pelajaran_id', $tahun_pelajaran->id)
            ->where('siswa_id', $data_siswa->id)
            ->get();

        $nilai_akhir = 0;
        for ($i = 0; $i < count($nilai); $i++) {
            $nilai_akhir = $nilai_akhir + $nilai[$i]->nilai_akhir;
        }

        // ambil data wali kelas siswa
        $data = WaliKelasSiswa::find($wali_kelas_siswa_id);

        return response()->json([
            'nilai_akhir' => $nilai_akhir,
            'data' => $data
        ]);
    }

    public function update_wali_kelas_siswa($id)
    {
        $data = WaliKelasSiswa::find($id);

        $data->update([
            'kelakuan' => request('kelakuan'),
            'kerajinan' => request('kerajinan'),
            'kebersihan' => request('kebersihan'),
            'sakit' => request('sakit'),
            'izin' => request('izin'),
            'alpha' => request('alpha'),
            'catatan_wali_kelas' => ucwords(request('catatan_wali_kelas')),
            'jumlah_nilai' => request('nilai_akhir'),
        ]);

        return response()->json([
            'message' => 'berhasil update wali kelas siswa'
        ]);
    }














    public function nilai($id, $wali_kelas_siswa_id, $siswa, $tahun_pelajaran, $semester, $peringkat)
    {
        // ambil data di table "tahun pelajaran" yang "tahun_pelajaran" sama dengan "$tahun_pelajaran" dan "semester" sama dengan "$semester" (ini untuk kebutuhan query nilai)
        $tahun_pelajaran = TahunPelajaran::where('tahun_pelajaran', $tahun_pelajaran)
            ->where('semester', $semester)
            ->first();

        // ambil data siswa
        $data_siswa = Siswa::find($siswa);

        $nilai_data = Nilai::where('tahun_pelajaran_id', $tahun_pelajaran->id)
            ->where('siswa_id', $data_siswa->id)
            ->get();

        // cek rata-rata nilai
        $nilai = [];
        $r2 = 0;
        foreach ($nilai_data as $n) {
            $jumlah = 0;

            $nilai_rata_rata = Nilai::where('tahun_pelajaran_id', $tahun_pelajaran->id)
                ->where('mapel_guru_id', $n->mapel_guru_id)
                ->get();
            $nrr = 0;

            foreach ($nilai_rata_rata as $nr) {
                $nrr = ($nrr + $nr->nilai_akhir);
            }
            $c = round($nrr / count($nilai_rata_rata));

            $nilai[] = [
                'mata_pelajaran' => $n->mapel_guru->mapel->nama_mata_pelajaran,
                'nilai_akhir' => $n->nilai_akhir,
                'nilai_akhir_terbilang' => terbilang($n->nilai_akhir),
                'rata_rata_nilai' => $c
            ];

            foreach ($nilai as $ni) {
                $jumlah = $jumlah + $ni['nilai_akhir'];
            }

            $r2 = round($jumlah / count($nilai));
        }

        // jumlah siswa
        $jumlah_siswa = WaliKelasSiswa::where('wali_kelas_id', $id)
            ->count();

        // wali kelas siswa yang dipilih
        $wali_kelas_siswa = WaliKelasSiswa::find($wali_kelas_siswa_id);

        // ambil data wali kelas
        $wali_kelas = WaliKelas::find($id);

        // cek response yang diberikan
        // return [
        //     'route_id' => $id,
        //     'route_siswa' => $siswa,
        //     'route_tahun_pelajaran' => $tahun_pelajaran,
        //     'route_semester' => $semester,
        //     'siswa' => $data_siswa,
        //     'tahun_pelajaran' => $tahun_pelajaran,
        //     'wali_kelas' => $wali_kelas,
        //     'nilai' => $nilai,
        //     'peringkat' => $peringkat,
        //     'jumlah_siswa' => $jumlah_siswa,
        //     'wali_kelas_siswa' => $wali_kelas_siswa
        // ];

        // menggunakan halaman baru
        // return view('wali_kelas.nilai', [
        //     'route_id' => $id,
        //     'route_siswa' => $siswa,
        //     'route_tahun_pelajaran' => $tahun_pelajaran,
        //     'route_semester' => $semester,
        //     'siswa' => $data_siswa,
        //     'tahun_pelajaran' => $tahun_pelajaran,
        //     'wali_kelas' => $wali_kelas,
        //     'nilai' => $nilai,
        //     'peringkat' => $peringkat,
        //     'jumlah_siswa' => $jumlah_siswa,
        //     'wali_kelas_siswa' => $wali_kelas_siswa
        // ]);

        // menggunakan modal
        return response()->json([
            'route_id' => $id,
            'route_siswa' => $siswa,
            'route_tahun_pelajaran' => $tahun_pelajaran,
            'route_semester' => $semester,
            'siswa' => $data_siswa,
            'tahun_pelajaran' => $tahun_pelajaran,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
            'peringkat' => $peringkat,
            'jumlah_siswa' => $jumlah_siswa,
            'wali_kelas_siswa' => $wali_kelas_siswa,
            'tanggal' => date('d F Y'),
            'jumlah' => $jumlah,
            'jumlah_terbilang' => terbilang($jumlah),
            'rata_rata' => $r2,
            'rata_rata_terbilang' => terbilang($r2),
            'wali_kelas' => Auth::user()->name
        ]);
    }
}
