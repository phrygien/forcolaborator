<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmobilisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immobilisations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('id_depense');
            $table->foreign('id_depense')->references('id')->on('listedepenses');
            $table->unsignedBigInteger('id_site');
            $table->foreign('id_site')->references('id')->on('sites');
            $table->unsignedBigInteger('id_batiment');
            $table->foreign('id_batiment')->references('id')->on('batiments');
            $table->double('pu');
            $table->double('qte');
            $table->double('valeur_disponible');
            $table->double('montant_total');
            $table->string('date_acquisition');
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
        Schema::dropIfExists('immobilisations');
    }
}
