<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_id');
            //$table->foreign('sensor_id')->references('id')->on('sensors');
            $table->dateTime('at');
            $table->float('value');
            $table->float('raw_value');
            //$table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade')->onUpdate('cascade');
            //$table->foreign('sensor_id')->references('id')->on('sensors');
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
        Schema::drop('measurements');
    }
}
