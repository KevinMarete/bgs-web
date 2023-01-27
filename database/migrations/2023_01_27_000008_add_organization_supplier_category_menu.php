<?php

use Illuminate\Database\Migrations\Migration;

class AddOrganizationSupplierCategoryMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->insert(
            ['name' => 'OrganizationSupplierCategory', 'link' => '/organizationsuppliercategories', 'icon' => 'layout', 'created_at' => now()]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->where('name', 'OrganizationSupplierCategory')->delete();
    }
}
