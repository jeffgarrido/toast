<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('Course_Id');
            $table->string('Code', 15);
            $table->string('Title', 50);
            $table->unsignedInteger('Units');
            $table->text('Description')->nullable();
            $table->enum('Terms', array(2,3,4));
            $table->timestamps();
        });

        $table_prefix = DB::getTablePrefix();
        DB::statement("ALTER TABLE `" . $table_prefix . "courses` CHANGE `Terms` `Terms` SET('2','3','4') NOT NULL DEFAULT '2';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
