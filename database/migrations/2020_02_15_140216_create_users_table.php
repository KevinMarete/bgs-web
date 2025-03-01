<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone', 20);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('organization_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');
        });

        //Add default data
        DB::table('tbl_user')->insert(
            array(
                [
                    'firstname' => 'Kevin', 
                    'lastname' => 'Marete',
                    'phone' => '0725102659',
                    'email' => 'kevomarete@gmail.com',
                    'password' => '$2y$10$Pm9//JP64ObJ9Eqj82u07uDZpXEFCNqDvkPqCFJ.P8IdDiZMUEys.',
                    'email_verified_at' => now(),
                    'organization_id' => '1', 
                    'created_at' => now(),
                    'updated_at' => now()
                ],[
                    'firstname' => 'Test', 
                    'lastname' => 'Chemist',
                    'phone' => '0725102658',
                    'email' => 'malibu@gmail.com',
                    'password' => '$2y$10$Pm9//JP64ObJ9Eqj82u07uDZpXEFCNqDvkPqCFJ.P8IdDiZMUEys.',
                    'email_verified_at' => now(),
                    'organization_id' => '2', 
                    'created_at' => now(),
                    'updated_at' => now()
                ],[
                    'firstname' => 'Test', 
                    'lastname' => 'Supplier',
                    'phone' => '0725102657',
                    'email' => 'kemsa@gmail.com',
                    'password' => '$2y$10$Pm9//JP64ObJ9Eqj82u07uDZpXEFCNqDvkPqCFJ.P8IdDiZMUEys.',
                    'email_verified_at' => now(),
                    'organization_id' => '3', 
                    'created_at' => now(),
                    'updated_at' => now()
                ]
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
        Schema::dropIfExists('tbl_user');
    }
}
