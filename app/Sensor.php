<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sensors';

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
    protected $fillable = ['sensor_unit_serial', 'index', 'sensor_type_id', 'offset', 'factor'];

    public function measurements()
    {
        return $this->hasMany('App\Measurement');
    }
    
}
