<?php

use Illuminate\Database\Migrations\Migration;

class UpdateSellerMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->where('name', 'Catalogue')->update(['name' => 'My Catalogue', 'icon' => 'database']);
        DB::table('tbl_menu')->where('name', 'Offers')->update(['name' => 'My Offers', 'icon' => 'gift']);
        DB::table('tbl_menu')->where('name', 'Stocks')->update(['name' => 'My Stocks', 'icon' => 'layers']);
        DB::table('tbl_menu')->where('name', 'Orders')->update(['name' => 'My Orders', 'icon' => 'list']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->where('name', 'My Catalogue')->update(['name' => 'Catalogue', 'icon' => 'tablet']);
        DB::table('tbl_menu')->where('name', 'My Offers')->update(['name' => 'Offers', 'icon' => 'activity']);
        DB::table('tbl_menu')->where('name', 'My Stocks')->update(['name' => 'Stocks', 'icon' => 'package']);
        DB::table('tbl_menu')->where('name', 'My Orders')->update(['name' => 'Orders', 'icon' => 'package']);
    }
}
