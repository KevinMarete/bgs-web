<?php

use Illuminate\Database\Migrations\Migration;

class AddRfqMenuBuyerSellerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $menu = DB::table('tbl_menu')->where('name', 'RFQ')->first();
        $buyer_role = DB::table('tbl_role')->where('name', 'buyer')->first();
        $seller_role = DB::table('tbl_role')->where('name', 'seller')->first();

        DB::table('tbl_menu_role')->insert(
            [
                ['menu_id' => $menu->id, 'role_id' => $buyer_role->id, 'created_at' => now()],
                ['menu_id' => $menu->id, 'role_id' => $seller_role->id, 'created_at' => now()]
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
        $menu = DB::table('tbl_menu')->where('name', 'RFQ')->first();
        $buyer_role = DB::table('tbl_role')->where('name', 'buyer')->first();
        $seller_role = DB::table('tbl_role')->where('name', 'seller')->first();

        DB::table('tbl_menu_role')->where('menu_id', $menu->id)->where('role_id', $buyer_role->id)->delete();
        DB::table('tbl_menu_role')->where('menu_id', $menu->id)->where('role_id', $seller_role->id)->delete();
    }
}
