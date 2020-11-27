<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');

            $table->string('descricao',255)->comment('descrição da despesa');
            $table->date('data')->comment('data de quando ocorreu a despesa');
            $table->string('anexo', 255)->comment('um anexo, com limite de 8mb');
            $table->decimal('valor', 9, 2);

            $table->timestamps();
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('despesas');
    }
}
