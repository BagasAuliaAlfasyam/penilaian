<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = ['tahun_pelajaran_id', 'mapel_guru_id', 'siswa_id', 'n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'rata_rata_n', 'uas', 'nilai_akhir'];

    public function siswa()
    {
        return $this->belongsTo('App\Models\Siswa', 'siswa_id', 'id');
    }

    public function mapel_guru()
    {
        return $this->belongsTo('App\Models\MapelGuru', 'mapel_guru_id', 'id');
    }
}
