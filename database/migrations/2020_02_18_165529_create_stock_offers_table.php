<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stock_offer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id')->unsigned();
            $table->integer('offer_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['stock_id', 'offer_id']);

            $table->foreign('stock_id')->references('id')->on('tbl_stock')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('tbl_offer')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_stock_offer');
    }
}
