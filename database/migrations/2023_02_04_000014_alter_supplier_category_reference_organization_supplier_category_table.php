<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSupplierCategoryReferenceOrganizationSupplierCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('tbl_organization_supplier_category', function (Blueprint $table) {
            $table->dropForeign(['supplier_category_id']);
            $table->foreign('supplier_category_id')
                ->references('id')
                ->on('tbl_product_category')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('tbl_organization_supplier_category', function (Blueprint $table) {
            $table->dropForeign(['supplier_category_id']);
            $table->foreign('supplier_category_id')
                ->references('id')
                ->on('tbl_supplier_category')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }
}
