<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_courier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('contact');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'email']);
        });

        //Add default data
        DB::table('tbl_courier')->insert(
            array(
                [
                    'name' => 'G4S Courier Services', 
                    'phone' => '0732171000', 
                    'email' => 'couriercs@ke.g4s.com', 
                    'contact' => 'Ashley Almanza',
                    'created_at' => now()
                ],
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
        Schema::dropIfExists('tbl_courier');
    }
}
