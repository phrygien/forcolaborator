<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepenseGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depense_globals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_libelle_depense');
            $table->foreign('id_libelle_depense')->references('id')->on('libelle_depenses');
            $table->unsignedBigInteger('id_type_depense');
            $table->foreign('id_type_depense')->references('id')->on('type_depenses');
            $table->string('date_entree');
            $table->float('qte');
            $table->float('montant_total');
            $table->integer('id_utilisateur');
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
        Schema::dropIfExists('depense_globals');
    }
}
