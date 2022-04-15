<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasarDesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasar_desa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kecamatan');
            $table->bigInteger('id_desa');
            $table->integer('tahun_berdiri');
            $table->integer('jumlah_pasar');
            $table->text('sejarah');
            $table->string('kegiatan_pasar');
            $table->string('status_lahan');
            $table->string('status_pengelolaan');
            $table->string('sumber_dana_pembangunan');
            $table->string('kondisi_bangunan');
            $table->string('kondisi_fisik_bangunan');
            $table->string('perlu_perbaikan');
            $table->string('bantuan_dari');
            $table->string('omzet');
            $table->string('jumlah_pelaku_usaha');
            $table->string('asal_pelaku_usaha');
            $table->string('dampak_sosial');
            $table->text('keterangan');
            $table->date('tanggal_simpan');
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
        Schema::dropIfExists('pasar_desa');
    }
}
