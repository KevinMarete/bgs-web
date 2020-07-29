<?php

use Illuminate\Database\Migrations\Migration;

class MoveFaqHowToMenusAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $faq_menu = DB::table('tbl_menu')->where('name', 'FAQs')->first();
        $how_to_menu = DB::table('tbl_menu')->where('name', 'How To')->first();
        $role = DB::table('tbl_role')->where('name', 'admin')->first();

        DB::table('tbl_menu_role')->where('menu_id', $faq_menu->id)->update(['role_id' => $role->id]);
        DB::table('tbl_menu_role')->where('menu_id', $how_to_menu->id)->update(['role_id' => $role->id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $faq_menu = DB::table('tbl_menu')->where('name', 'FAQs')->first();
        $how_to_menu = DB::table('tbl_role')->where('name', 'How To')->first();
        $role = DB::table('tbl_role')->where('name', 'buyer')->first();

        DB::table('tbl_menu_role')->where('menu_id', $faq_menu->id)->update(['role_id' => $role->id]);
        DB::table('tbl_menu_role')->where('menu_id', $how_to_menu->id)->update(['role_id' => $role->id]);
    }
}
