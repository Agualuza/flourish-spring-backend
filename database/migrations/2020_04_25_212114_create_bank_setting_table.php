<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bank_id')->unsigned();
            $table->bigInteger('option_id')->unsigned();
            $table->foreign('bank_id')->references('id')->on('bank');
            $table->foreign('option_id')->references('id')->on('option');
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
        Schema::dropIfExists('bank_setting');
    }
}
