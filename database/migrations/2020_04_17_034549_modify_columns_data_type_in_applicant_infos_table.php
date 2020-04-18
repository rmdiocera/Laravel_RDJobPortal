<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsDataTypeInApplicantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_infos', function (Blueprint $table) {
            $table->integer('gender')->charset(null)->collation(null)->change();
            $table->integer('country')->charset(null)->collation(null)->change();
            $table->integer('nationality')->charset(null)->collation(null)->change();
            $table->integer('degree')->charset(null)->collation(null)->change();
            $table->integer('course')->charset(null)->collation(null)->change();
            $table->integer('currency')->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_infos', function (Blueprint $table) {
            $table->string('gender')->change();
            $table->string('country')->change();
            $table->string('nationality')->change();
            $table->string('degree')->change();
            $table->string('course')->change();
            $table->dropColumn('currency');
        });
    }
}
