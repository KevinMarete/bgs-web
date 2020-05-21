<?php

use Illuminate\Database\Migrations\Migration;

class AddMyProductsMenu extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    DB::table('tbl_menu')->insert(
      ['name' => 'My Products', 'link' => '/products', 'icon' => 'package', 'created_at' => now()]
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    DB::table('tbl_menu')->where('name', 'My Products')->delete();
  }
}
