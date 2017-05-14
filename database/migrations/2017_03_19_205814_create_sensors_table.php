<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors', function(Blueprint $table) {
            $table->increments('id');
            $table->string('sensor_unit_serial');
            $table->integer('index');
            $table->integer('sensor_type_id');
            $table->float('offset');
            $table->float('factor');
            $table->string('comment');
            //$table->foreign('sensor_unit_serial')->references('serial')->on('sensor_units'); //->onDelete('cascade')->onUpdate('cascade');
            //$table->foreign('sensor_unit_serial')->references('serial')->on('sensor_units');
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
        Schema::drop('sensors');
    }
}
