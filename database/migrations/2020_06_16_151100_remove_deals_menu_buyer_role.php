<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDealsMenuBuyerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $menu = DB::table('tbl_menu')->where('name', 'Deals')->first();
        $role = DB::table('tbl_role')->where('name', 'buyer')->first();

        DB::table('tbl_menu_role')->where('menu_id', $menu->id)->where('role_id', $role->id)->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $menu = DB::table('tbl_menu')->where('name', 'Deals')->first();
        $role = DB::table('tbl_role')->where('name', 'buyer')->first();

        DB::table('tbl_menu_role')->insert(
            ['menu_id' => $menu->id, 'role_id' => $role->id, 'created_at' => now()]
        );
    }
}
