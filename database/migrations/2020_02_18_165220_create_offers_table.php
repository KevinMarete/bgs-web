<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_offer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->timestamp('valid_from');
            $table->timestamp('valid_until');
            $table->integer('discount')->unsigned();
            $table->double('max_discount_amount', 8, 2);
            $table->integer('organization_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['description', 'organization_id']);

            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_offer');
    }
}
