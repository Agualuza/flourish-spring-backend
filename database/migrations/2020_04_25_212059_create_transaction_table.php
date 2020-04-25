<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bank_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('option_id')->unsigned();
            $table->foreign('bank_id')->references('id')->on('bank');
            $table->foreign('customer_id')->references('id')->on('customer');
            $table->foreign('option_id')->references('id')->on('option');
            $table->string('code',15)->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('transaction_type',1)->comment("B - buy , S - sell");
            $table->string('transaction_status')->comment("O - open , C - closed");
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
        Schema::dropIfExists('transaction');
    }
}
