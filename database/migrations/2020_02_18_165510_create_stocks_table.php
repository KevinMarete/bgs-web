<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->string('batch_number');
            $table->date('expiry_date');
            $table->integer('quantity')->unsigned();
            $table->integer('balance')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('stock_type_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['transaction_date', 'batch_number', 'expiry_date', 'quantity', 'balance', 'product_id', 'stock_type_id', 'organization_id', 'user_id']);

            $table->foreign('product_id')->references('id')->on('tbl_product')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('stock_type_id')->references('id')->on('tbl_stock_type')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('tbl_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_stock');
    }
}
