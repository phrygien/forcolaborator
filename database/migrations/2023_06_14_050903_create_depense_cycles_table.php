<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepenseCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depense_cycles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cycle');
            $table->foreign('id_cycle')->references('id')->on('cycles');
            $table->unsignedBigInteger('id_depense');
            $table->foreign('id_depense')->references('id')->on('listedepenses');
            $table->unsignedBigInteger('id_utilisation');
            $table->foreign('id_utilisation')->references('id')->on('utilisaction_charges');
            $table->unsignedBigInteger('type_depense');
            $table->foreign('type_depense')->references('id')->on('type_depenses');
            $table->double('qte');
            $table->double('valeur');
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
        Schema::dropIfExists('depense_cycles');
    }
}
