<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstatPoulardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constat_poulards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cycle');
            $table->integer('nb_poulet');
            $table->string('date_constat');
            $table->integer('nb_disponible');
            $table->integer('retour')->default(0);
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
        Schema::dropIfExists('constat_poulards');
    }
}
