<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListedepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listedepenses', function (Blueprint $table) {
            $table->id();
            $table->string('nom_depense');
            $table->unsignedBigInteger('id_unite');
            $table->foreign('id_unite')->references('id')->on('unites');
            $table->string('cycle_concerne');
            $table->string('affectation');
            $table->string('type');
            $table->integer('nb_annee_amortissement');
            $table->integer('actif')->default(0);
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
        Schema::dropIfExists('listedepenses');
    }
}
