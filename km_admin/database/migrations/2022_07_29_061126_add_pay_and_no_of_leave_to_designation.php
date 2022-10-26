<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayAndNoOfLeaveToDesignation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designation', function (Blueprint $table) {
            //
            $table->string('pay')->after('designation');
            $table->string('no_of_leave')->after('designation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designation', function (Blueprint $table) {
            //
            $table->dropColumn('pay');
            $table->dropColumn('no_of_leave');
        });
    }
}
