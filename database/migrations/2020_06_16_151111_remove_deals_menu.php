<?php

use Illuminate\Database\Migrations\Migration;

class RemoveDealsMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->where('name', 'Deals')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->insert(
            ['name' => 'Deals', 'link' => '/deals', 'icon' => 'activity', 'created_at' => now()]
        );
    }
}
