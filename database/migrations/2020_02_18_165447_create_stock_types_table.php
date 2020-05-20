<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stock_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('effect')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'effect']);
        });

        //Add default data
        DB::table('tbl_stock_type')->insert(
            array(
                ['name' => 'Stock-In', 'effect' => '1', 'created_at' => now()],
                ['name' => 'Sale', 'effect' => '-1', 'created_at' => now()],
                ['name' => 'Starting Stock/Physical Count', 'effect' => '0', 'created_at' => now()]
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
        Schema::dropIfExists('tbl_stock_type');
    }
}
