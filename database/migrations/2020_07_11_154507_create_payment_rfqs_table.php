<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payment_rfq', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->unsigned();
            $table->integer('rfq_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['payment_id', 'rfq_id']);

            $table->foreign('payment_id')->references('id')->on('tbl_payment')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rfq_id')->references('id')->on('tbl_rfq')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_payment_rfq');
    }
}
