<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApplicationStatusColumnNameInJobPostApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_post_applications', function (Blueprint $table) {
            $table->renameColumn('application_status', 'app_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_post_applications', function (Blueprint $table) {
            $table->renameColumn('app_status_id', 'application_status');
        });
    }
}
