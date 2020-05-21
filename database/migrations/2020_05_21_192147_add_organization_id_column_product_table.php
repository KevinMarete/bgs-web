<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizationIdColumnProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_product', function (Blueprint $table) {
            $table->integer('organization_id')->unsigned()->nullable()->after('product_category_id');
        });

        DB::table('tbl_product')->whereNull('organization_id')->update(['organization_id' => 3]);

        Schema::table('tbl_product', function (Blueprint $table) {
            $table->integer('organization_id')->nullable(false)->change();
            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');

            $table->dropUnique(['molecular_name', 'brand_name', 'pack_size', 'strength', 'product_category_id']);
            $table->unique(['molecular_name', 'brand_name', 'pack_size', 'strength', 'product_category_id', 'organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_product', function ($table) {
            $table->dropUnique(['molecular_name', 'brand_name', 'pack_size', 'strength', 'product_category_id', 'organization_id']);
            $table->dropColumn('organization_id');
            $table->unique(['molecular_name', 'brand_name', 'pack_size', 'strength', 'product_category_id']);
        });
    }
}
