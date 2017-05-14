<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSensorTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('unit_name');
            $table->string('fa_icon');
            $table->float('default_offset');
            $table->float('default_factor');
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
        Schema::drop('sensor_types');
    }
}
