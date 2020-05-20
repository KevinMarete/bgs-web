<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationPaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_organization_payment_type', function (Blueprint $table) {
            $table->increments('id');
            $table->json('details');
            $table->integer('organization_id')->unsigned();
            $table->integer('payment_type_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id']);

            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('tbl_payment_type')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_organization_payment_type');
    }
}
