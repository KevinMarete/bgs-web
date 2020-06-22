<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyerMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_menu')->insert(
            [
                ['name' => 'Marketplace', 'link' => '/marketplace', 'icon' => 'shopping-bag', 'created_at' => now()],
                ['name' => 'Offers of the Day', 'link' => '/offers-day', 'icon' => 'gift', 'created_at' => now()],
                ['name' => 'My Cart', 'link' => '/cart', 'icon' => 'shopping-cart', 'created_at' => now()],
                ['name' => 'FAQs', 'link' => '/faqs', 'icon' => 'help-circle', 'created_at' => now()],
                ['name' => 'Contact Us', 'link' => '/contact-us', 'icon' => 'phone-call', 'created_at' => now()]
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
        DB::table('tbl_menu')->where('name', 'Marketplace')->delete();
        DB::table('tbl_menu')->where('name', 'Offers of the Day')->delete();
        DB::table('tbl_menu')->where('name', 'My Cart')->delete();
        DB::table('tbl_menu')->where('name', 'FAQs')->delete();
        DB::table('tbl_menu')->where('name', 'Contact Us')->delete();
    }
}
