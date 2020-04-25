<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('bank_id')->unsigned();
            $table->bigInteger('level_id')->unsigned();
            $table->decimal('balance', 10, 2)->nullable();
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('bank_id')->references('id')->on('bank');
            $table->foreign('level_id')->references('id')->on('level');
            $table->string('cpf')->nullable();
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
        Schema::dropIfExists('customer');
    }
}
