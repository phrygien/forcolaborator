<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisationDepenesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisation_depeneses', function (Blueprint $table) {
            $table->id();
            $table->string('date_utilisation');
            $table->float('qte');
            $table->float('montant');
            $table->integer('utilisation_cicble');
            $table->unsignedBigInteger('id_depense_brut');
            $table->foreign('id_depense_brut')->references('id')->on('depense_globals');
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
        Schema::dropIfExists('utilisation_depeneses');
    }
}
