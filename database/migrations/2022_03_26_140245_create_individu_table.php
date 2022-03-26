<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik');
            $table->string('nik');
            $table->string('jenis_kelamin');
            $table->string('no_hp');
            $table->string('nama_usaha');
            $table->string('alamat_usaha');
            $table->bigInteger('id_kecamatan');
            $table->bigInteger('id_desa');
            $table->bigInteger('id_kategori_komoditas');
            $table->bigInteger('id_komoditas');
            $table->bigInteger('id_sub_komoditas');
            $table->bigInteger('id_pendidikan');
            $table->integer('tahun_berdiri');
            $table->integer('status');
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
        Schema::dropIfExists('individu');
    }
}
