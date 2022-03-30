<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsahaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usaha', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kecamatan');
            $table->bigInteger('id_desa');
            $table->bigInteger('id_individu');
            $table->integer('jumlah_tenaga_kerja');
            $table->decimal('harga_jual_produk', 10, 2);
            $table->integer('hari_kerja_sebulan');
            $table->decimal('nilai_investasi', 10, 2);
            $table->decimal('omzet_perhari', 10, 2);
            $table->decimal('nilai_asset', 10, 2);
            $table->string('pernah_menerima_pembinaan');
            $table->string('layanan_ukm');
            $table->string('bantuan_alat');
            $table->string('produk_dihasilkan');
            $table->string('terima_modal_dari');
            $table->string('apakah_sudah_dikemas');
            $table->string('teknik_pemasaran');
            $table->string('bahan_kemasan');
            $table->string('asal_konsumen');
            $table->string('cara_kemasan');
            $table->string('sarana_penunjang_produksi');
            $table->string('asal_bahan_baku');
            $table->string('kondisi_bangunan');
            $table->string('dampak_sosial_ekonomi');
            $table->string('npwp');
            $table->string('keterangan');
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
        Schema::dropIfExists('usaha');
    }
}
