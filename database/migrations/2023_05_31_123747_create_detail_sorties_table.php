<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSortiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_sorties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sortie');
            $table->unsignedBigInteger('id_constat');
            $table->string('id_produit');
            $table->float('qte');
            $table->float('valeur');
            $table->float('pu');
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
        Schema::dropIfExists('detail_sorties');
    }
}
