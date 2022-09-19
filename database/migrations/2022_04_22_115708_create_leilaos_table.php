<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeilaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leilaos', function (Blueprint $table) {
            $table->id();
            $table->double('valor_minimo');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->integer('numero_ganhadores');
            $table->double('taxa_cobrada');
            $table->string('porcetagem_caminho')->nullable(true);
            $table->foreignId('proposta_id')->constrained();
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
        Schema::dropIfExists('leilaos');
    }
}
