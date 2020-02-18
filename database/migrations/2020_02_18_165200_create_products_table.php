<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('molecular_name');
            $table->string('brand_name');
            $table->integer('pack_size')->unsigned();
            $table->integer('minimum_order_quantity')->unsigned();
            $table->double('unit_price', 8, 2);
            $table->double('delivery_cost', 8, 2);
            $table->integer('product_category_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['molecular_name', 'brand_name', 'pack_size', 'product_category_id']);

            $table->foreign('product_category_id')->references('id')->on('tbl_product_category')->onUpdate('cascade')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_product');
    }
}
