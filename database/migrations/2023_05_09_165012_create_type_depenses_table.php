<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_depenses', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->unsignedBigInteger('id_categorie');
            $table->integer('actif');
            $table->foreign('id_categorie')->references('id')->on('categorie_depenses');
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
        Schema::dropIfExists('type_depenses');
    }
}
