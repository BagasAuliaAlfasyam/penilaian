<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;

    protected $fillable = ['guru_id', 'tahun_pelajaran', 'semester', 'jurusan', 'kelas', 'status'];

    public function guru()
    {
        return $this->belongsTo('App\Models\Guru', 'guru_id', 'id');
    }
}
