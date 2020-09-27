<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->json('conteudo');

            $table->unsignedBigInteger('problema_id');
            $table->foreign('problema_id')->references('id')->on('problemas');

            $table->unsignedBigInteger('trabalho_id');
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respostas');
    }
}
