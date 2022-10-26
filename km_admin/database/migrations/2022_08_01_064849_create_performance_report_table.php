<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_report', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('employee_id');
            $table->string('department');
            $table->string('designation');
            $table->timestamp('joining_date')->nullable();
            $table->timestamp('period_from')->nullable();
            $table->timestamp('period_to')->nullable();
            $table->string('reviewer_name')->nullable();
            $table->timestamp('date_of_review')->nullable();
            $table->string('preformance_in_brief')->nullable();
            $table->string('work_to_full_potential')->nullable();
            $table->string('communication')->nullable();
            $table->string('productivity')->nullable();
            $table->string('punctuality')->nullable();
            $table->string('attendence')->nullable();
            $table->string('technical_Skills')->nullable();
            $table->timestamps('deleted_at')->nullable();
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
        Schema::dropIfExists('performance_report');
    }
}
