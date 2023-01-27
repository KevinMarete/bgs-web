<?php

use Illuminate\Database\Migrations\Migration;

class AddSupplierCategoryMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->insert(
            ['name' => 'SupplierCategory', 'link' => '/suppliercategories', 'icon' => 'layers', 'created_at' => now()]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->where('name', 'SupplierCategory')->delete();
    }
}
