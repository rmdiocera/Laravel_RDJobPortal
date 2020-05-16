<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyOverviewAndModifyWebsiteLinkInEmployerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employer_infos', function (Blueprint $table) {
            $table->mediumText('company_overview')->after('website_link');
            $table->string('website_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employer_infos', function (Blueprint $table) {
            $table->dropColumn('company_overview');
            $table->string('website_link')->nullable(false)->change();
        });
    }
}
