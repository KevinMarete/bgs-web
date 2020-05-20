<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->unsigned();
            $table->double('unit_price', 8, 2);
            $table->double('shipping_price', 8, 2);
            $table->double('sub_total', 8, 2);
            $table->double('shipping_total', 8, 2);
            $table->double('discount', 8, 2)->default('0');
            $table->double('total_cost', 8, 2);
            $table->integer('product_now_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['product_now_id', 'organization_id', 'order_id']);

            $table->foreign('product_now_id')->references('id')->on('tbl_product_now')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('tbl_order')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_order_item');
    }
}
