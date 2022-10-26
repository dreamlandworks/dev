<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelieveLetterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relieve_letter', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('employee_id');
            $table->string('department');
            $table->string('designation');
            $table->string('joining_date');
            $table->string('date_of_relieving');
            $table->string('resignation_letter');
            $table->text('relieve_content');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('relieve_letter');
    }
}
