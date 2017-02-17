<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutcomeStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_outcomes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Outcome_Id');
            $table->integer('Student_Id');
            $table->integer('P1');
            $table->integer('P2');
            $table->integer('P3');
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
        //
    }
}
