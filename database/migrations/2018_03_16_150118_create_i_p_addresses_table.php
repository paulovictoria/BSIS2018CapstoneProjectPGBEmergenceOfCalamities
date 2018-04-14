<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIPAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_p_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->string('dateStart');
            $table->string('dateFinished');
            $table->integer('ip_id')->unsigned()->index();
            $table->integer('count');
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
        Schema::dropIfExists('i_p_addresses');
    }
}
