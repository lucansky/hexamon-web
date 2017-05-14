<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gateways';

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
    protected $fillable = ['serial', 'description'];


    public function sensorUnits()
    {
        return $this->hasMany('App\SensorUnit');
    }

}
