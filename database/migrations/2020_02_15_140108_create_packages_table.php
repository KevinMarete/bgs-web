<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_package', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('price', 8, 2);
            $table->json('details');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name']);
        });

        //Add default data
        DB::table('tbl_package')->insert(
            array(
                ['name' => 'Basic', 'price' => '1000', 'created_at' => now(), 'details' => json_encode(['Limited access to promos & deals', 'Limited access to sellers', 'Email support', 'Help center access'])],
                ['name' => 'Professional', 'price' => '3000', 'created_at' => now(), 'details' => json_encode(['Medium access to promos & deals', 'Medium access to sellers', 'Priority email support', 'Help center access'])],
                ['name' => 'Enterprise', 'price' => '5000', 'created_at' => now(), 'details' => json_encode(['All access to promos & deals', 'All access to sellers', 'Phone and email support', 'Help center access'])]
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
        Schema::dropIfExists('tbl_package');
    }
}
