<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductShippingTotalColumnTypeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_order', function (Blueprint $table) {
            $table->decimal('product_total', 8, 2)->change();
            $table->decimal('shipping_total', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_order', function (Blueprint $table) {
            $table->integer('product_total')->change();
            $table->integer('shipping_total')->change();
        });
    }
}
