<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTideUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tide_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date_gathered');
            $table->string('tideTime');
            $table->string('tideHeight_mt');
            $table->string('tideDateTime');
            $table->string('tideType');
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
        Schema::dropIfExists('tide_updates');
    }
}
