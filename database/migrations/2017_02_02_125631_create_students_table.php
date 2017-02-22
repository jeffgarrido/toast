<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('students', function (Blueprint $table) {
            $table->increments('Student_Id')->unique();
            $table->unsignedSmallInteger('Account_Id');
            $table->integer('StudentNumber');
            $table->enum('AcademicStatus', ['Regular', 'Irregular'])->default('Regular');
            $table->string('Section')->nullable();
            $table->string('FirstName', 50);
            $table->string('MiddleName', 50)->nullable();
            $table->string('LastName', 50);
            $table->date('Birthday');
            $table->string('Phone')->nullable();
            $table->string('PersonalEmail')->nullable();
            $table->string('Nickname', 50)->nullable();
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
