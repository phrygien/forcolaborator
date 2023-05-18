<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortieOeufsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sortie_oeufs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_type_oeuf');
            $table->unsignedBigInteger('id_type_sortie');
            $table->integer('qte');
            $table->float('pu');
            $table->float('montant');
            $table->integer('actif')->default(1);
            $table->integer('id_utilisateur');
            $table->string('date_action');
            $table->unsignedInteger('id_client');
            $table->string('date_sortie');
            $table->foreign('id_type_oeufs')->references('id')->on('type_oeufs');
            $table->foreign('id_type_sortie')->references('id')->on('type_sorties');
            $table->foreign('id_client')->references('id')->on('clients');
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
        Schema::dropIfExists('sortie_oeufs');
    }
}
