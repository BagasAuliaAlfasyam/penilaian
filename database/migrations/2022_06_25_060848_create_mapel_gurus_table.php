<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapelGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapel_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_pelajaran_id');
            $table->foreign('tahun_pelajaran_id')->references('id')->on('tahun_pelajarans');
            $table->foreignId('guru_id');
            $table->foreign('guru_id')->references('id')->on('gurus');
            $table->foreignId('mapel_id');
            $table->foreign('mapel_id')->references('id')->on('mata_pelajarans');
            $table->integer('kelas');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('mapel_gurus');
    }
}
