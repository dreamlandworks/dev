<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketStatisticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_statistice', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_campaign');
            $table->string('ends_in');
            $table->string('leads_generated');
            $table->string('leads_converted');
            $table->string('projected_budget');
            $table->string('expenditure_till_date');
            $table->string('cac');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_statistice');
    }
}
