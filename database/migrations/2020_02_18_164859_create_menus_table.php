<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('link');
            $table->string('icon');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name']);
        });

        //Add default data
        DB::table('tbl_menu')->insert(
            array(
                ['name' => 'Dashboard', 'link' => '/dashboard', 'icon' => 'activity', 'created_at' => now()],
                ['name' => 'OrganizationTypes', 'link' => '/organizationtypes', 'icon' => 'layout', 'created_at' => now()],
                ['name' => 'Packages', 'link' => '/packages', 'icon' => 'package', 'created_at' => now()],
                ['name' => 'Roles', 'link' => '/roles', 'icon' => 'filter', 'created_at' => now()],
                ['name' => 'ProductCategories', 'link' => '/product-categories', 'icon' => 'activity', 'created_at' => now()],
                ['name' => 'StockTypes', 'link' => '/stocktypes', 'icon' => 'package', 'created_at' => now()],
                ['name' => 'PaymentTypes', 'link' => '/payment-types', 'icon' => 'package', 'created_at' => now()],
                ['name' => 'Catalogue', 'link' => '/catalogue', 'icon' => 'tablet', 'created_at' => now()],
                ['name' => 'Products', 'link' => '/products', 'icon' => 'package', 'created_at' => now()],
                ['name' => 'Offers', 'link' => '/offers', 'icon' => 'activity', 'created_at' => now()],
                ['name' => 'Stocks', 'link' => '/stocks', 'icon' => 'package', 'created_at' => now()],
                ['name' => 'OrderNow', 'link' => '/ordernow', 'icon' => 'filter', 'created_at' => now()],
                ['name' => 'Deals', 'link' => '/deals', 'icon' => 'activity', 'created_at' => now()],
                ['name' => 'Promos', 'link' => '/promos', 'icon' => 'bar-chart', 'created_at' => now()],
                ['name' => 'Orders', 'link' => '/orders', 'icon' => 'package', 'created_at' => now()],
                ['name' => 'Menus', 'link' => '/menus', 'icon' => 'tablet', 'created_at' => now()],
                ['name' => 'MenuRoles', 'link' => '/menu-roles', 'icon' => 'tablet', 'created_at' => now()],
                ['name' => 'Couriers', 'link' => '/couriers', 'icon' => 'package', 'created_at' => now()],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_menu');
    }
}
