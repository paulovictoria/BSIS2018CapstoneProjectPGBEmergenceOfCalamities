<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned();
            $table->string('token');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('is_verified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_verifications');
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
}
