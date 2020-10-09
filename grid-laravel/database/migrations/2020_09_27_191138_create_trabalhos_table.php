<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalhos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            /*
            status | significado
               0   | livre para ser executado
               1   | está sendo executado
               2   | desativado/desligado
               3   | ja executado com sucesso
            */
            $table->smallInteger('status');
            $table->json('conteudo');

            $table->unsignedBigInteger('problema_id');
            $table->unsignedBigInteger('ultima_vez_requisitado', 0);

            $table->foreign('problema_id')->references('id')->on('problemas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabalhos');
    }
}
