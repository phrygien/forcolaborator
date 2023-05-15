<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrixPouletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prix_poulets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_type_poulet');
            $table->foreign('id_type_poulet')->references('id')->on('type_poulets');
            $table->string('date_application');
            $table->float('pu_kg');
            $table->integer('actif')->default(1);
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
        Schema::dropIfExists('prix_poulets');
    }
}
