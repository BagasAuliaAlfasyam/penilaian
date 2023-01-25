<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Guru::count();
        $siswa = Siswa::count();
        $mapel = MataPelajaran::count();
        return view('admin.dashboard.dashboard', [
            'guru' => $guru,
            'siswa' => $siswa,
            'mapel' => $mapel
        ]);
    }
}
