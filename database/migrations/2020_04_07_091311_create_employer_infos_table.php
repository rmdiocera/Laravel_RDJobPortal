<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_infos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('industry');
            $table->string('address');
            $table->string('website_link');
            $table->string('company_size');
            $table->string('benefits');
            $table->string('dress_code');
            $table->string('spoken_language');
            $table->string('work_hours');
            $table->string('avg_processing_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employer_infos');
    }
}
