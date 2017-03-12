<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_requirements', function (Blueprint $table) {
            $table->increments('Requirement_Id');
            $table->unsignedInteger('BaseClass_Id');
            $table->string('Name', 100);
            $table->integer('HPS')->default(0);
            $table->double('Weight', 3,2)->default(0);
            $table->text('Description');
            $table->enum('Term', array(1,2,3,4));
            $table->timestamps();
        });

        $table_prefix = DB::getTablePrefix();
        DB::statement("ALTER TABLE `" . $table_prefix . "course_requirements` CHANGE `Term` `Term` SET('1','2','3','4') NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_requirements');
    }
}
