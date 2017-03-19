<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_announcements', function (Blueprint $table) {
            $table->increments('Announcement_Id');
            $table->integer('Organization_Id')->unsigned();
            $table->string('Title',100);
            $table->string('Announcement',255);
            $table->string('Uploaded_by',50);
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
