<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_student', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('Organization_Id');
            $table->unsignedSmallInteger('Student_Id');
            $table->string('Position', 20)->default('Member');
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
