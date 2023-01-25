<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_pelajaran_id');
            $table->foreign('tahun_pelajaran_id')->references('id')->on('tahun_pelajarans');
            $table->foreignId('mapel_guru_id');
            $table->foreign('mapel_guru_id')->references('id')->on('mapel_gurus');
            $table->foreignId('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->integer('n1')->default(0);
            $table->integer('n2')->default(0);
            $table->integer('n3')->default(0);
            $table->integer('n4')->default(0);
            $table->integer('n5')->default(0);
            $table->integer('n6')->default(0);
            $table->integer('rata_rata_n')->default(0);
            $table->integer('uas')->default(0);
            $table->integer('nilai_akhir')->default(0);
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
        Schema::dropIfExists('nilais');
    }
}
