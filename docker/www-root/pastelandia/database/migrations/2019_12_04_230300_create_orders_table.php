<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('cod_cliente')->unsigned();
            $table->bigInteger('cod_pastel')->unsigned();
            $table->foreign('cod_cliente')->references('id')->on('clients')->onDelete('no action');
            $table->foreign('cod_pastel')->references('id')->on('pasteis')->onDelete('no action');
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
        Schema::dropIfExists('orders');
    }
}
