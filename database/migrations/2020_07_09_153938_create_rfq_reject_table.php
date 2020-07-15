<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqRejectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_rfq_reject', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rfq_id')->unsigned();
            $table->integer('reject_reason_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['rfq_id', 'reject_reason_id']);

            $table->foreign('rfq_id')->references('id')->on('tbl_rfq')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reject_reason_id')->references('id')->on('tbl_reject_reason')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_rfq_reject');
    }
}
