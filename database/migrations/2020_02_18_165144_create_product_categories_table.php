<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name']);
        });

        //Add default data
        DB::table('tbl_product_category')->insert(
            array(
                ['name' => 'Pharmaceutical', 'created_at' => now()],
                ['name' => 'Laboratory Devices and Reagents', 'created_at' => now()],
                ['name' => 'Medical Equipment', 'created_at' => now()]
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
        Schema::dropIfExists('tbl_product_category');
    }
}
