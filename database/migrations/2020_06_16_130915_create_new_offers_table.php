<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_offer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->timestamp('valid_from');
            $table->timestamp('valid_until');
            $table->string('display_url');
            $table->integer('discount')->unsigned();
            $table->integer('min_order_quantity')->unsigned();
            $table->double('max_discount_amount', 8, 2)->nullable(true);
            $table->integer('product_now_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['status', 'valid_from', 'valid_until', 'discount', 'min_order_quantity', 'product_now_id', 'organization_id']);

            $table->foreign('product_now_id')->references('id')->on('tbl_product_now')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_offer');
    }
}
