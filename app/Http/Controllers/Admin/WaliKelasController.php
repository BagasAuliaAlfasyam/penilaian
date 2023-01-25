<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\User;
use App\Models\Guru;
use App\Models\WaliKelas;
use App\Models\WaliKelasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaliKelasController extends Controller
{
    public function index()
    {
        $guru = Guru::orderBy('nama_guru', 'asc')
            ->get();
        $tahun_pelajaran = DB::table('tahun_pelajarans')
            ->select('tahun_pelajaran')
            ->groupBy('tahun_pelajaran')
            ->get();
        $wali_kelas = WaliKelas::orderBy('status', 'desc')
            ->get();

        if (request()->ajax()) {
            return datatables()->of($wali_kelas)
                ->addColumn('guru', function ($wali_kelas) {
                    return $wali_kelas->guru->nama_guru;
                })
                ->addColumn('status', function ($wali_kelas) {
                    if ($wali_kelas->status == 0) {
                        $status = '<span class="badge bg-dark rounded-pill">Tidak Aktif</span>';
                    } else {
                        $status = '<span class="badge bg-primary rounded-pill">Aktif</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($wali_kelas) {
                    $button = '<button class="btn btn-sm btn-success ms-1 edit-wali-kelas" data-bs-toggle="modal" data-bs-target="#staticBackdropEdit" id="' . $wali_kelas->id . '">Edit</button>';
                    if ($wali_kelas->status == 0) {
                        $button .= "<button class='btn btn-sm btn-primary ms-1 aktifkan' id='" . $wali_kelas->id . "' id_guru='" . $wali_kelas->guru_id . "'>Aktifkan</button>";
                    } else {
                        $button .= "<button class='btn btn-sm btn-dark ms-1 non-aktifkan' id='" . $wali_kelas->id . "'>Non Aktifkan</button>";
                    }
                    $button .= "<a href='/wali_kelas/" . $wali_kelas->id . "/siswa' class='btn btn-sm btn-info ms-1'>Siswa</a>";
                    return $button;
                })
                ->rawColumns(['guru', 'status', 'action'])
                ->make(true);
        }

        return view('admin.wali_kelas.wali_kelas', [
            'guru' => $guru,
            'tahun_pelajaran' => $tahun_pelajaran
        ]);
    }

    public function show($id)
    {
        $wali_kelas = WaliKelas::find($id);

        return response()->json([
            'data' => $wali_kelas
        ]);
    }

    public function store()
    {
        request()->validate([
            'guru' => 'required',
            'tahun_pelajaran' => 'required',
            'semester' => 'required',
            'kelas' => 'required'
        ], [
            'guru.required' => 'Guru harus dipilih',
            'tahun_pelajaran.required' => 'Tahun pelajaran harus dipilih',
            'semester.required' => 'Semester harus dipilih',
            'kelas.required' => 'Kelas harus dipilih',
        ]);

        // cek jika datanya sudah ada
        $cekDuplikat = WaliKelas::where('tahun_pelajaran', request('tahun_pelajaran'))
            ->where('semester', request('semester'))
            ->where('kelas', request('kelas'))
            ->get();

        if (count($cekDuplikat) > 0) {
            return response()->json([
                'duplikat' => 'Tahun pelajaran, semester dan kelas ini sudah terdaftar'
            ]);
        } else {

            // cek siswa yang dipilih berdasarkan kelas ada atau tidak
            $cek_siswa = Siswa::where('kelas', request('kelas'))->count();
            if ($cek_siswa < 1) {
                return response()->json([
                    'duplikat' => 'Siswa di kelas ini belum ada, silahkan tambahkan siswa nya dulu'
                ]);
            } else {
                // masukan data wali kelas
                $wali_kelas = WaliKelas::create([
                    'guru_id' => request('guru'),
                    'tahun_pelajaran' => request('tahun_pelajaran'),
                    'semester' => request('semester'),
                    'kelas' => request('kelas'),
                    'status' => 0,
                ]);

                // ambil siswa berdasarkan kelas yang dipilih
                $siswa = Siswa::where('kelas', request('kelas'))->get();

                // masukan semua siswa berdasarkan kelas yang dipilih ke table wali_kelas_siswas
                for ($i = 0; $i < count($siswa); $i++) {
                    WaliKelasSiswa::create([
                        'wali_kelas_id' => $wali_kelas->id,
                        'siswa_id' => $siswa[$i]->id
                    ]);
                }
            }
        }
    }

    public function update($id)
    {
        request()->validate([
            'guru_edit' => 'required'
        ], [
            'guru_edit.required' => 'Guru harus dipilih'
        ]);

        // cek wali kelas yang akan di edit status nya
        $cek_status_wali_kelas = WaliKelas::find($id);

        if ($cek_status_wali_kelas->status == 1) {
            // dalam 3 wali kelas aktif tidak boleh ada nama yang sama
            $cek_wali_kelas_yang_namanya_sama = WaliKelas::where('guru_id', request('guru_edit'))
                ->where('status', 1)
                ->get();


            if (count($cek_wali_kelas_yang_namanya_sama) > 0 && request('guru_edit') !== request('id_guru')) {
                return response()->json([
                    'duplikat' => 'Tidak boleh ada nama yang sama, di wali kelas yang aktif'
                ]);
            } else {
                // ambil data guru yang lama
                $guru_lama = Guru::find(request('id_guru'));
                // ambil user nya
                $user_guru_lama = User::find($guru_lama->user_id);
                // update user nya
                $user_guru_lama->update([
                    'role' => 'guru'
                ]);

                // update wali kelas nya
                $wali_kelas = WaliKelas::find($id);
                $wali_kelas->update([
                    'guru_id' => request('guru_edit')
                ]);

                // ambil data guru yang baru
                $guru = Guru::find($wali_kelas->guru_id);
                // ambil user nya
                $user = User::find($guru->user_id);
                // update user nya
                $user->update([
                    'role' => 'wali_kelas'
                ]);

                return response()->json([
                    'message' => 'Wali kelas berhasil di edit'
                ]);
            }
        } else {
            $wali_kelas = WaliKelas::find($id);
            $wali_kelas->update([
                'guru_id' => request('guru_edit')
            ]);

            return response()->json([
                'message' => 'Wali kelas berhasil di edit'
            ]);
        }
    }

    public function aktifkan($id, $id_guru)
    {
        // cek jumlah wali kelas yang aktif, maksimal harus 3 karena kelas nya ada 3
        $cek_jumlah_wali_kelas = WaliKelas::where('status', 1)
            ->get();

        if (count($cek_jumlah_wali_kelas) >= 3) {
            return response()->json([
                'duplikat' => 'Wali kelas yang aktif tidak boleh lebih dari 3 orang'
            ]);
        } else {

            // dalam 3 wali kelas aktif tidak boleh ada nama yang sama
            $cek_wali_kelas_yang_namanya_sama = WaliKelas::where('guru_id', $id_guru)
                ->where('status', 1)
                ->get();

            if (count($cek_wali_kelas_yang_namanya_sama) > 0) {
                return response()->json([
                    'duplikat' => 'Tidak boleh ada nama yang sama, di wali kelas yang aktif',
                    'cek' => count($cek_wali_kelas_yang_namanya_sama)
                ]);
            } else {
                // ambil data wali kelas
                $wali_kelas = WaliKelas::find($id);
                // update status nya 
                $wali_kelas->update([
                    'status' => 1
                ]);

                // ambil gurunya
                $guru = Guru::find($wali_kelas->guru_id);

                // ambil user guru nya
                $user = User::find($guru->user_id);
                // update role access nya
                $user->update([
                    'role' => 'wali_kelas'
                ]);

                return response()->json([
                    'message' => 'Berhasil mengaktifkan guru ini menjadi wali kelas',
                    'cek' => count($cek_wali_kelas_yang_namanya_sama)
                ]);
            }
        }
    }

    public function non_aktifkan($id)
    {
        // ambil data wali kelas
        $wali_kelas = WaliKelas::find($id);
        $wali_kelas->update([
            'status' => 0
        ]);

        // ambil data guru 
        $guru = Guru::find($wali_kelas->guru_id);

        // ambil data user
        $user = User::find($guru->user_id);
        // update role access nya
        $user->update([
            'role' => 'guru'
        ]);

        return response()->json([
            'message' => 'berhasil menonaktifkan wali kelas'
        ]);
    }

    public function wali_kelas_siswa($wali_kelas_id)
    {
        return view('admin.wali_kelas.siswa', [
            'route_id' => $wali_kelas_id
        ]);
    }

    public function ambil_data($wali_kelas_id)
    {
        $wali_kelas_siswa = WaliKelasSiswa::join('siswas', 'siswas.id', '=', 'wali_kelas_siswas.siswa_id')
            ->join('wali_kelas', 'wali_kelas.id', '=', 'wali_kelas_siswas.wali_kelas_id')
            ->where('wali_kelas_id', $wali_kelas_id)
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

    public function update_wali_kelas_siswa_admin($id)
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
            'wali_kelas' => $wali_kelas->guru->nama_guru,
            'nilai' => $nilai,
            'peringkat' => $peringkat,
            'jumlah_siswa' => $jumlah_siswa,
            'wali_kelas_siswa' => $wali_kelas_siswa,
            'tanggal' => date('d F Y'),
            'jumlah' => $jumlah,
            'jumlah_terbilang' => terbilang($jumlah),
            'rata_rata' => $r2,
            'rata_rata_terbilang' => terbilang($r2)
        ]);
    }

    public function print($id, $wali_kelas_siswa_id, $siswa, $tahun_pelajaran, $semester, $peringkat)
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

        // menggunakan halaman baru
        return view('admin.wali_kelas.print', [
            'route_id' => $id,
            'route_siswa' => $siswa,
            'route_tahun_pelajaran' => $tahun_pelajaran,
            'route_semester' => $semester,
            'siswa' => $data_siswa,
            'tahun_pelajaran' => $tahun_pelajaran,
            'wali_kelas' => $wali_kelas->guru->nama_guru,
            'nilai' => $nilai,
            'peringkat' => $peringkat,
            'jumlah_siswa' => $jumlah_siswa,
            'wali_kelas_siswa' => $wali_kelas_siswa,
            'tanggal' => date('d F Y'),
            'jumlah' => $jumlah,
            'jumlah_terbilang' => terbilang($jumlah),
            'rata_rata' => $r2,
            'rata_rata_terbilang' => terbilang($r2)
        ]);
    }
}
