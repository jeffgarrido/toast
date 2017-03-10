<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentOutcomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_outcomes', function (Blueprint $table) {
            $table->increments('Outcome_Id');
            $table->string('Outcome_Code', 20);
            $table->text('Description');
            $table->text('P1_Description');
            $table->text('P2_Description');
            $table->text('P3_Description');
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
        Schema::dropIfExists('student_outcomes');
    }
}
