<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpbLicenceColumnOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_organization', function (Blueprint $table) {
            $table->string('ppb_licence')->nullable()->after('building');
        });

        DB::table('tbl_organization')->whereNull('ppb_licence')->update(['ppb_licence' => 'PPB/TMP/' . date('Y') . '/000000']);

        Schema::table('tbl_organization', function (Blueprint $table) {
            $table->string('ppb_licence')->nullable(false)->change();

            $table->dropUnique(['name', 'organization_type_id']);
            $table->unique(['name', 'organization_type_id', 'ppb_licence']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_organization', function ($table) {
            $table->dropUnique(['name', 'organization_type_id', 'ppb_licence']);
            $table->dropColumn('ppb_licence');
            $table->unique(['name', 'organization_type_id']);
        });
    }
}
