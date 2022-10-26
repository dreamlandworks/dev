<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('mobile_no');
            $table->string('local_address');
            $table->string('permanent_address');
            $table->string('photo');
            $table->string('email');
            $table->string('password');
            $table->string('employee_id');
            $table->string('date_of_joining');
            $table->string('department');
            $table->string('designation');
            $table->string('joining_salery');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('ifsc_code');
            $table->string('pan_number');
            $table->string('branch');
            $table->string('document_path');
            $table->string('resume');
            $table->string('offer_letter');
            $table->string('joining_letter');
            $table->string('contract_and_agreement');
            $table->string('id_proof');
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
        Schema::dropIfExists('employee');
    }
}
