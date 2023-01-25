<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelGuru extends Model
{
    use HasFactory;

    protected $fillable = ['tahun_pelajaran_id', 'guru_id', 'mapel_id', 'kelas', 'status'];

    public function guru()
    {
        return $this->belongsTo('App\Models\Guru', 'guru_id', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo('App\Models\MataPelajaran', 'mapel_id', 'id');
    }

    public function tahun_pelajaran()
    {
        return $this->belongsTo('App\Models\TahunPelajaran', 'tahun_pelajaran_id', 'id');
    }
}
