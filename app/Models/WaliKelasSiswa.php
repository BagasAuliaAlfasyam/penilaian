<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelasSiswa extends Model
{
    use HasFactory;

    protected $fillable = ['wali_kelas_id', 'siswa_id', 'kelakuan', 'kerajinan', 'kebersihan', 'sakit', 'izin', 'alpha', 'jumlah_nilai', 'catatan_wali_kelas'];

    public function siswa()
    {
        return $this->belongsTo('App\Models\Siswa', 'siswa_id', 'id');
    }

    public function wali_kelas()
    {
        return $this->belongsTo('App\Models\WaliKelas', 'wali_kelas_id', 'id');
    }
}
