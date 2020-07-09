<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_rfq_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('user_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('rfq_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['status', 'user_id', 'organization_id', 'rfq_id']);

            $table->foreign('user_id')->references('id')->on('tbl_user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('tbl_organization')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rfq_id')->references('id')->on('tbl_rfq')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_rfq_log');
    }
}
