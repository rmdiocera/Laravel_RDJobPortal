<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMobilePhoneNumberDataTypeInApplicantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_infos', function (Blueprint $table) {
            $table->string('mobile_phone_no', 11)->change();
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
            $table->integer('mobile_phone_no')->change();
        });
    }
}
