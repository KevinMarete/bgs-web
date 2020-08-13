<?php

use Illuminate\Database\Migrations\Migration;

class RenameContactUsHowToMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->where('name', 'Contact Us')->update(['name' => 'How To', 'icon' => 'search', 'link' => 'how-tos']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->where('name', 'How To')->update(['name' => 'Contact Us', 'icon' => 'phone-call', 'link' => 'contact-us']);
    }
}
