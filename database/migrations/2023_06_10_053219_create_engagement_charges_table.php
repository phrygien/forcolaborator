<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngagementChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engagement_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_depense');
            $table->foreign('id_depense')->references('id')->on('listedepenses');
            $table->double('pu');
            $table->double('qte');
            $table->double('prix_total');
            $table->double('qte_disponible');
            $table->string('date_engagement');
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
        Schema::dropIfExists('engagement_charges');
    }
}
