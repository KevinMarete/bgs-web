<?php

use Illuminate\Database\Migrations\Migration;

class CreateRfqMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->insert(
            ['name' => 'RFQ', 'link' => '/rfq', 'icon' => 'git-pull-request', 'created_at' => now()]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_menu')->where('name', 'RFQ')->delete();
    }
}
