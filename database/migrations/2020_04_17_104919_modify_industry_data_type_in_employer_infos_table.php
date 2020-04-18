<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyIndustryDataTypeInEmployerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employer_infos', function (Blueprint $table) {
            $table->integer('industry')->charset(null)->collation(null)->change();
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
            $table->string('industry')->change();
        });
    }
}
