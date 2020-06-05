<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUserIdSubscriptionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tbl_subscription', function (Blueprint $table) {
      $table->dropUnique(['user_id']);
      $table->dropForeign(['user_id']);
      $table->renameColumn('user_id', 'organization_id');
      $table->unique(['organization_id']);
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
    Schema::table('tbl_subscription', function (Blueprint $table) {
      $table->dropUnique(['organization_id']);
      $table->dropForeign(['organization_id']);
      $table->renameColumn('organization_id', 'user_id');
      $table->unique(['user_id']);
      $table->foreign('user_id')->references('id')->on('tbl_user')->onUpdate('cascade')->onDelete('cascade');
    });
  }
}
