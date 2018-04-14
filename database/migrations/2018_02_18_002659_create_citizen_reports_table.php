<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitizenReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizen_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName');
            $table->string('address');
            $table->string('contactNumber')->nullable();
            $table->string('landline')->nullable();
            $table->string('landmark');
            $table->string('type');
            $table->string('reportedDate');
            $table->string('municipality');
            $table->string('rescuedTime');
            $table->string('respondTime');
            $table->string('status');
            $table->string('lat');
            $table->string('lng');
            $table->string('ip');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('citizen_reports');
    }
}
