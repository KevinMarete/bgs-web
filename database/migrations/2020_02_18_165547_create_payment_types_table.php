<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payment_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->json('details');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name']);
        });

        //Add default data
        DB::table('tbl_payment_type')->insert(
            array(
                ['name' => 'Bank Transfer', 'created_at' => now(), 'details' => json_encode(['bank_name', 'bank_branch', 'account_number'])],
                ['name' => 'Pay Bill', 'created_at' => now(), 'details' => json_encode(['business_number', 'account_number'])],
                ['name' => 'Buy Goods and Services', 'created_at' => now(), 'details' => json_encode(['till_number'])]
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
        Schema::dropIfExists('tbl_payment_type');
    }
}
