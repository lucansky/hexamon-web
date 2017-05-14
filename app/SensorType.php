<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sensor_types';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'unit_name','fa_icon','default_offset', 'default_factor'];

    
}
