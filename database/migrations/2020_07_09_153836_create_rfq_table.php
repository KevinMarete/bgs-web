<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_rfq', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->string('terms')->nullable();
            $table->integer('organization_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('tbl_rfq');
    }
}
