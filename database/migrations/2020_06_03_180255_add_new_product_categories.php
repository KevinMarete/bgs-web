<?php

use Illuminate\Database\Migrations\Migration;

class AddNewProductCategories extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    DB::table('tbl_product_category')->insert(
      [
        ['name' => 'Health and Wellness', 'created_at' => now()],
        ['name' => 'Medical Supplies', 'created_at' => now()]
      ]
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    DB::table('tbl_product_category')->where('name', 'Health and Wellness')->delete();
    DB::table('tbl_product_category')->where('name', 'Medical Supplies')->delete();
  }
}
