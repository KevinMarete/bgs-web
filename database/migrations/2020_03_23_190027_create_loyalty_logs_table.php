<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoyaltyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_loyalty_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('points')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->integer('loyalty_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['status', 'points', 'order_id', 'loyalty_id']);

            $table->foreign('order_id')->references('id')->on('tbl_order')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('loyalty_id')->references('id')->on('tbl_loyalty')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_loyalty_log');
    }
}
