<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdCycleSortiePoulets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sortie_poulets', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cycle');
            $table->foreign('id_cycle')->references('id')->on('cycles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sortie_poulets', function (Blueprint $table) {
            //
        });
    }
}
