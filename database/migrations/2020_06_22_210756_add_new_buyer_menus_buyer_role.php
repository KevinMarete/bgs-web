<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewBuyerMenusBuyerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Get buyer role_id
        $role = DB::table('tbl_role')->where('name', 'buyer')->first();

        //Remove 'OrderNow' and 'My Orders' menus to allow new menu ordering
        $ordernow_menu = DB::table('tbl_menu')->where('name', 'OrderNow')->first();
        $orders_menu = DB::table('tbl_menu')->where('name', 'My Orders')->first();
        DB::table('tbl_menu_role')->whereIn('menu_id', [$ordernow_menu->id, $orders_menu->id])->where('role_id', $role->id)->delete();

        //Get all buyer menus
        $menus = ['Marketplace', 'OrderNow', 'Offers of the Day', 'My Cart', 'My Orders', 'FAQs', 'Contact Us'];
        foreach ($menus as $menu_name) {
            $menu = DB::table('tbl_menu')->where('name', $menu_name)->first();
            $insert_data[] = ['menu_id' => $menu->id, 'role_id' => $role->id, 'created_at' => now()];
        }
        //Assign all buyer menus to buyer role
        DB::table('tbl_menu_role')->insert($insert_data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Get buyer role_id
        $role = DB::table('tbl_role')->where('name', 'buyer')->first();

        //Get all buyer menus except previous ones of 'OrderNow' and 'My Orders'
        $menus = DB::table('tbl_menu')
            ->whereIn('name', ['Marketplace', 'Offers of the Day', 'My Cart', 'FAQs', 'Contact Us'])
            ->get();

        $delete_menus = [];
        foreach ($menus as $menu) {
            $delete_menus[] = $menu->id;
        }
        //Remove all new buyer menus
        DB::table('tbl_menu_role')->whereIn('menu_id', $delete_menus)->where('role_id', $role->id)->delete();
    }
}
