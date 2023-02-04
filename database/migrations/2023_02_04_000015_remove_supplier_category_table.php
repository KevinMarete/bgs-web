<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tbl_supplier_category');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('tbl_supplier_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        //Add default data
        DB::table('tbl_supplier_category')->insert(
            array(
                ['name' => 'Pharmaceutical', 'created_at' => now()],
                ['name' => 'Hospital Equipment', 'created_at' => now()],
                ['name' => 'Diagnostics', 'created_at' => now()],
                ['name' => 'Non-Pharms', 'created_at' => now()],
            )
        );
    }
}
