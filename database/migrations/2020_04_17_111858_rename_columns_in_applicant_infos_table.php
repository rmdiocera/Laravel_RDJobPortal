<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInApplicantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_infos', function (Blueprint $table) {
            $table->renameColumn('gender', 'gender_id');
            $table->renameColumn('country', 'country_id');
            $table->renameColumn('nationality', 'nationality_id');
            $table->renameColumn('currency', 'currency_id');
            $table->renameColumn('degree', 'degree_id');
            $table->renameColumn('course', 'course_id');
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
            $table->renameColumn('gender_id', 'gender');
            $table->renameColumn('country_id', 'country');
            $table->renameColumn('nationality_id', 'nationality');
            $table->renameColumn('currency_id', 'currency');
            $table->renameColumn('degree_id', 'degree');
            $table->renameColumn('course_id', 'course');
        });
    }
}
