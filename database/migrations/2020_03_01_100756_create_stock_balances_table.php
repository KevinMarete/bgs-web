<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stock_balance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('batch_number');
            $table->date('expiry_date');
            $table->integer('quantity')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['batch_number', 'expiry_date', 'product_id', 'organization_id']);

            $table->foreign('product_id')->references('id')->on('tbl_product')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_stock_balance');
    }
}
