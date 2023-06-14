<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisactionChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisaction_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_depense');
            $table->foreign('id_depense')->references('id')->on('listedepenses');
            $table->unsignedBigInteger('id_site')->nullable();
            $table->foreign('id_site')->references('id')->on('sites');
            $table->unsignedBigInteger('id_cycle')->nullable();
            $table->foreign('id_cycle')->references('id')->on('cycles');
            $table->double('qte');
            $table->string('date_utilisation');
            $table->integer('id_utilisateur');
            $table->integer('avec_retour')->default(0);
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
        Schema::dropIfExists('utilisaction_charges');
    }
}
