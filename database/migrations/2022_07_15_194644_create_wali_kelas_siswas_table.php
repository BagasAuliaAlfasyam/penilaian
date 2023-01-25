<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaliKelasSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali_kelas_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wali_kelas_id');
            $table->foreign('wali_kelas_id')->references('id')->on('wali_kelas');
            $table->foreignId('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->string('kelakuan')->nullable();
            $table->string('kerajinan')->nullable();
            $table->string('kebersihan')->nullable();
            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alpha')->default(0);
            $table->integer('jumlah_nilai')->default(0);
            $table->string('catatan_wali_kelas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wali_kelas_siswas');
    }
}
