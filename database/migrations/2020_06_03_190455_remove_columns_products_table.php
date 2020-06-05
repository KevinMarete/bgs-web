<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tbl_product', function ($table) {
      $table->string('strength')->nullable(true)->change();
      $table->dropColumn('minimum_order_quantity');
      $table->dropColumn('unit_price');
      $table->dropColumn('delivery_cost');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tbl_product', function (Blueprint $table) {
      $table->string('strength')->nullable(false)->change();
      $table->integer('minimum_order_quantity')->unsigned()->nullable(true);
      $table->double('unit_price', 8, 2)->nullable(true);
      $table->double('delivery_cost', 8, 2)->nullable(true);
    });
  }
}
