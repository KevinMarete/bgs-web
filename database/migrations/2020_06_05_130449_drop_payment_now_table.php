<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPaymentNowTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::dropIfExists('tbl_payment_now');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::create('tbl_payment_now', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('payment_id')->unsigned();
      $table->integer('product_now_id')->unsigned();
      $table->timestamps();
      $table->softDeletes();

      $table->unique(['payment_id', 'product_now_id']);

      $table->foreign('payment_id')->references('id')->on('tbl_payment')->onUpdate('cascade')->onDelete('cascade');
      $table->foreign('product_now_id')->references('id')->on('tbl_product_now')->onUpdate('cascade')->onDelete('cascade');
    });
  }
}
