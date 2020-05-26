<?php

use Illuminate\Database\Migrations\Migration;

class UpdateCataloguePricelistMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->where('name', 'My Catalogue')->update(['name' => 'My PriceList', 'link' => '/pricelist']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->where('name', 'My PriceList')->update(['name' => 'My Catalogue', 'link' => '/catalogue']);
    }
}
