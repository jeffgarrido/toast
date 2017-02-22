<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_student', function(Blueprint $table) {
           $table->increments('id');
           $table->unsignedInteger('Event_Id');
           $table->unsignedInteger('Student_Id');
           $table->enum('PaymentStatus', ['Unpaid', 'Paid'])->default('Unpaid');
           $table->dateTime('Attendance');
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
