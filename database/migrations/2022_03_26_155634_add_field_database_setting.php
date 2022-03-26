<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDatabaseSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('database_setting', function (Blueprint $table) {
            $table->string('database_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('database_setting', function (Blueprint $table) {
            $table->dropColumn(['database_file']);
        });
    }
}
