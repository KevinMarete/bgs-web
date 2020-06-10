<?php

use Illuminate\Database\Migrations\Migration;

class RemovePromosMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->where('name', 'Promos')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->insert(
            ['name' => 'Promos', 'link' => '/promos', 'icon' => 'bar-chart', 'created_at' => now()]
        );
    }
}
