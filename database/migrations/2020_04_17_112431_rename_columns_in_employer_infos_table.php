<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInEmployerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employer_infos', function (Blueprint $table) {
            $table->renameColumn('industry', 'industry_id');
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
            $table->renameColumn('industry_id', 'industry');
        });
    }
}
