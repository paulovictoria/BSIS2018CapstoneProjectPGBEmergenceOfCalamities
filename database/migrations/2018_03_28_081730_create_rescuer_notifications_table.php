<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRescuerNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rescuer_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('citizen_name');
            $table->string('type');
            $table->string('location');
            $table->string('landmark');
            $table->string('time');
            $table->string('status');
            $table->string('image')->nullable();
            $table->integer('geolocation_id')->unsigned()->index();
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
        Schema::dropIfExists('rescuer_notifications');
    }
}
