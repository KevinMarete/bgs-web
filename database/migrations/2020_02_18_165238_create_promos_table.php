<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_promo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_code');
            $table->integer('offer_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['coupon_code', 'offer_id']);

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
        Schema::dropIfExists('tbl_promo');
    }
}
