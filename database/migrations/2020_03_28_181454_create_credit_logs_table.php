<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_credit_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('amount')->unsigned();
            $table->integer('credit_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('credit_id')->references('id')->on('tbl_credit')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_credit_log');
    }
}
