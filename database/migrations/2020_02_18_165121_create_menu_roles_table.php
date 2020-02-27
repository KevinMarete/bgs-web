<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_menu_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['menu_id', 'role_id']);

            $table->foreign('menu_id')->references('id')->on('tbl_menu')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('tbl_role')->onUpdate('cascade')->onDelete('cascade');
        });

        //Add default data
        DB::table('tbl_menu_role')->insert(
            array(
                ['menu_id' => '1', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '2', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '3', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '4', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '5', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '6', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '7', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '8', 'role_id' => '3', 'created_at' => now()],
                ['menu_id' => '9', 'role_id' => '1', 'created_at' => now()],
                ['menu_id' => '10', 'role_id' => '3', 'created_at' => now()],
                ['menu_id' => '11', 'role_id' => '3', 'created_at' => now()],
                ['menu_id' => '12', 'role_id' => '2', 'created_at' => now()],
                ['menu_id' => '13', 'role_id' => '2', 'created_at' => now()],
                ['menu_id' => '14', 'role_id' => '2', 'created_at' => now()],
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
        Schema::dropIfExists('tbl_menu_role');
    }
}
