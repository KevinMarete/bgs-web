<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('town');
            $table->string('road');
            $table->string('building');
            $table->integer('organization_type_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'organization_type_id']);

            $table->foreign('organization_type_id')->references('id')->on('tbl_organization_type')->onUpdate('cascade')->onDelete('cascade');
        });

        //Add default data
        DB::table('tbl_organization')->insert(
            array([
                'name' => 'BGS', 
                'town' => 'Nairobi', 
                'road' => 'Market Street', 
                'building' => 'Yala Towers', 
                'organization_type_id' => '1', 
                'created_at' => now()
            ])
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_organization');
    }
}
