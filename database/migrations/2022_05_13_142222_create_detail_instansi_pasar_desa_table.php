<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailInstansiPasarDesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_instansi_pasar_desa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pasar_desa');
            $table->bigInteger('id_instansi_pembina');
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
        Schema::dropIfExists('detail_instansi_pasar_desa');
    }
}
