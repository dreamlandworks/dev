<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('profession_id');
            $table->string('qualification_id');
            $table->string('experience_id');
            $table->string('languages');
            $table->string('skills');
            $table->string('aboutUs');
            $table->string('perHour');
            $table->string('perDay');
            $table->string('minCharges');
            $table->string('maxCharges');
            $table->string('startDate');
            $table->string('endDate');
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
        Schema::dropIfExists('service_providers');
    }
}
