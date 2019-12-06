<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('nome', 128);
            $table->string('email', 128)->unique();
            $table->string('telefone', 25)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 80)->nullable();
            $table->string('cep', 9)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('clients');

    }
}
