<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MapelGuruController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\TahunPelajaranController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\WaliKelasController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\Guru\NilaiSiswaController;
use App\Http\Controllers\Guru\PenilaianController;
use App\Http\Controllers\WaliKelas\KelasKuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['logged']], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/store', [AuthController::class, 'store']);
});

Route::group(['middleware' => ['auth']], function () {

    // access untuk admin
    Route::group(['middleware' => ['accessAdmin']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::get('/guru', [GuruController::class, 'index']);
        Route::get('/guru/tambah', [GuruController::class, 'add']);
        Route::post('/guru/tambah', [GuruController::class, 'store']);
        Route::get('/guru/edit/{id}', [GuruController::class, 'edit']);
        Route::post('/guru/update/{id}', [GuruController::class, 'update']);
        Route::delete('/guru/delete/{id}', [GuruController::class, 'delete']);

        Route::get('/siswa', [SiswaController::class, 'index']);
        Route::get('/siswa/tambah', [SiswaController::class, 'add']);
        Route::post('/siswa/tambah', [SiswaController::class, 'store']);
        Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit']);
        Route::post('/siswa/update/{id}', [SiswaController::class, 'update']);
        Route::delete('/siswa/delete/{id}', [SiswaController::class, 'delete']);

        Route::get('/mata_pelajaran', [MataPelajaranController::class, 'index']);
        Route::get('/mata_pelajaran/ambilData', [MataPelajaranController::class, 'ambilData']);
        Route::get('/mata_pelajaran/detail/{id}', [MataPelajaranController::class, 'show']);
        Route::post('/mata_pelajaran/tambah', [MataPelajaranController::class, 'store']);
        Route::post('/mata_pelajaran/edit/{id}', [MataPelajaranController::class, 'update']);
        Route::delete('/mata_pelajaran/hapus/{id}', [MataPelajaranController::class, 'delete']);

        Route::get('/tahun_pelajaran', [TahunPelajaranController::class, 'index']);
        Route::post('/tahun_pelajaran/tambah', [TahunPelajaranController::class, 'store']);
        Route::get('/tahun_pelajaran/edit/{id}', [TahunPelajaranController::class, 'edit']);
        Route::post('/tahun_pelajaran/update/{id}', [TahunPelajaranController::class, 'update']);

        Route::get('/tahun_pelajaran/{id}/mapel_guru', [MapelGuruController::class, 'index']);
        Route::post('/tahun_pelajaran/{id}/mapel_guru/tambah', [MapelGuruController::class, 'store']);
        Route::get('/tahun_pelajaran/{tp_id}/mapel_guru/{id}/edit', [MapelGuruController::class, 'edit']);
        Route::post('/tahun_pelajaran/{tp_id}/mapel_guru/{id}/update', [MapelGuruController::class, 'update']);
        Route::post('/tahun_pelajaran/{tp_id}/mapel_guru/{id}/publish', [MapelGuruController::class, 'publish']);
        Route::delete('/tahun_pelajaran/{tp_id}/mapel_guru/{id}/hapus', [MapelGuruController::class, 'delete']);

        Route::get('/tahun_pelajaran/{tp_id}/mapel_guru/{id}/detail', [NilaiController::class, 'index']);
        Route::get('/tahun_pelajaran/{tp_id}/mapel_guru/{id_mp_ust}/detail/{id_nilai}/edit', [NilaiController::class, 'edit']);
        Route::post('/tahun_pelajaran/{tp_id}/mapel_guru/{id_mp_ust}/detail/{id_nilai}/update', [NilaiController::class, 'update']);

        Route::get('/wali_kelas', [WaliKelasController::class, 'index']);
        Route::get('/wali_kelas/{id}', [WaliKelasController::class, 'show']);
        Route::post('/wali_kelas/tambah', [WaliKelasController::class, 'store']);
        Route::post('/wali_kelas/edit/{id}', [WaliKelasController::class, 'update']);
        Route::post('/wali_kelas/aktifkan/{id}/{id_guru}', [WaliKelasController::class, 'aktifkan']);
        Route::post('/wali_kelas/nonaktifkan/{id}', [WaliKelasController::class, 'non_aktifkan']);

        Route::get('/wali_kelas/{wali_kelas_id}/siswa', [WaliKelasController::class, 'wali_kelas_siswa']);
        Route::get('/wali_kelas/{wali_kelas_id}/ambil_data', [WaliKelasController::class, 'ambil_data']);
        Route::get('/wali_kelas/{id}/wali_kelas_siswa/{wali_kelas_siswa_id}/siswa_client/{siswa}/tp/{tahun_pelajaran}/sm/{semester}/data_edit', [WaliKelasController::class, 'data_edit'])->where('tahun_pelajaran', '(.*)');
        Route::post('/wali_kelas_siswa_admin/{id}', [WaliKelasController::class, 'update_wali_kelas_siswa_admin']);
        Route::get('/wali_kelas/{id}/wali_kelas_siswa/{wali_kelas_siswa_id}/siswa_client/{siswa}/tp/{tahun_pelajaran}/sm/{semester}/peringkat/{peringkat}', [WaliKelasController::class, 'nilai'])->where('tahun_pelajaran', '(.*)');
        Route::get('/wali_kelas/{id}/wali_kelas_siswa/{wali_kelas_siswa_id}/siswa_client/{siswa}/tp/{tahun_pelajaran}/sm/{semester}/peringkat/{peringkat}/print', [WaliKelasController::class, 'print'])->where('tahun_pelajaran', '(.*)');
    });

    // access untuk guru dan wali kelas
    Route::group(['middleware' => ['accessGuruDanWaliKelas']], function () {
        Route::get('/penilaian', [PenilaianController::class, 'index']);

        Route::get('/penilaian/tahun_pelajaran_id/{tahun_pelajaran_id}/mapel_guru_id/{mapel_guru_id}/nilai_siswa', [NilaiSiswaController::class, 'index']);
        Route::get('/penilaian/tahun_pelajaran_id/{id_thn_pelajaran}/mapel_guru_id/{id_mapel_guru}/nilai_siswa/{id_nilai}/detail', [NilaiSiswaController::class, 'detail']);
        Route::post('/penilaian/tahun_pelajaran_id/{id_thn_pelajaran}/mapel_guru_id/{id_mapel_guru}/nilai_siswa/{id_nilai}/update', [NilaiSiswaController::class, 'update']);



        // access untuk wali kelas
        Route::group(['middleware' => ['accessWaliKelas']], function () {
            Route::get('/kelasku', [KelasKuController::class, 'index']);


            // siswa datatable server side
            // Route::get('/kelasku/{id}/siswa', [KelasKuController::class, 'siswa']); 
            // Route::get('/kelasku/{id}/siswa/{siswa}/tp/{tahun_pelajaran?}/sm/{semester}/kl/{kelas}', [KelasKuController::class, 'nilai'])->where('tahun_pelajaran', '(.*)'); 


            // siswa datatable client side
            Route::get('/kelasku/{id}/siswa_client', [KelasKuController::class, 'siswa_client']);
            Route::get('/kelasku/{id}/ambil_data', [KelasKuController::class, 'ambil_data']);
            Route::get('/kelasku/{id}/wali_kelas_siswa/{wali_kelas_siswa_id}/siswa_client/{siswa}/tp/{tahun_pelajaran}/sm/{semester}/data_edit', [KelasKuController::class, 'data_edit'])->where('tahun_pelajaran', '(.*)');

            Route::post('/wali_kelas_siswa/{id}', [KelasKuController::class, 'update_wali_kelas_siswa']);

            Route::get('/kelasku/{id}/wali_kelas_siswa/{wali_kelas_siswa_id}/siswa_client/{siswa}/tp/{tahun_pelajaran}/sm/{semester}/peringkat/{peringkat}', [KelasKuController::class, 'nilai'])->where('tahun_pelajaran', '(.*)');
        });
    });


    Route::get('/ubah_password', [UbahPasswordController::class, 'index']);
    Route::post('/ubah_password', [UbahPasswordController::class, 'ubah_password']);

    Route::get('/logout', [AuthController::class, 'logout']);
});


// Route::get('/pilih', function () {
//     return view('layout.pilih', [
//         'data1' => 22,
//         'data2' => 28
//     ]);
// });