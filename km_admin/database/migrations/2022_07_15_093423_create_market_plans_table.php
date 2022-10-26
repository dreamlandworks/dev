<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_ad_campaign');
            $table->string('period');
            $table->string('campaign_type');
            $table->string('target_age_group');
            $table->string('gender');
            $table->string('date_of_start');
            $table->string('targeted_user_group');
            $table->string('budget_estimated');
            $table->string('document_path');
            $table->string('attachment');
            $table->string('content');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_plans');
    }
}
