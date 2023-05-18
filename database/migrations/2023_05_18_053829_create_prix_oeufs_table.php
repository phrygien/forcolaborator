<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrixOeufsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prix_oeufs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_type_oeuf');
            $table->string('date_application');
            $table->float('pu');
            $table->integer('actif')->default(1);
            $table->integer('id_utilisateur');
            $table->foreign('id_type_oeuf')->references('id')->on('type_oeufs');
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
        Schema::dropIfExists('prix_oeufs');
    }
}
