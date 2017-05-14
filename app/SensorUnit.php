<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorUnit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sensor_units';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'serial';

    public $incrementing = false;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['serial', 'description', 'last_seen'];

    public function gateway()
    {
        return $this->belongsTo('App\Gateway');
    }

    public function sensors()
    {
        return $this->hasMany('App\Sensor');
    }
}
