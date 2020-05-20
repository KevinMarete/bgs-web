<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_organization_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'role_id']);

            $table->foreign('role_id')->references('id')->on('tbl_role')->onUpdate('cascade')->onDelete('cascade');
        });

        //Add default data
        DB::table('tbl_organization_type')->insert(
            array(
                ['name' => 'Admin', 'role_id' => '1', 'created_at' => now()],
                ['name' => 'Hospital', 'role_id' => '2', 'created_at' => now()],
                ['name' => 'Chemist', 'role_id' => '2', 'created_at' => now()],
                ['name' => 'Clinic', 'role_id' => '2', 'created_at' => now()],
                ['name' => 'Pharmacy', 'role_id' => '2', 'created_at' => now()],
                ['name' => 'Supplier', 'role_id' => '3', 'created_at' => now()],
                ['name' => 'Distributor', 'role_id' => '3', 'created_at' => now()]
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
        Schema::dropIfExists('tbl_organization_type');
    }
}
