<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortiePouletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sortie_poulets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_type_poulet');
            $table->foreign('id_type_poulet')->references('id')->on('type_poulets');
            $table->unsignedBigInteger('id_type_sortie');
            $table->foreign('id_type_sortie')->references('id')->on('type_sorties');
            $table->double('poids_total');
            $table->integer('nombre');
            $table->float('prix_unite');
            $table->string('date_sortie');
            $table->unsignedBigInteger('id_client');
            $table->integer('id_utilisateur');
            $table->string('date_action');
            $table->integer('actif');
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
        Schema::dropIfExists('sortie_poulets');
    }
}
