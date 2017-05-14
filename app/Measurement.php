<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'measurements';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    protected $dates = [
        'created_at',
        'updated_at',
        'at'
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['sensor_id', 'at', 'value', 'raw_value'];

    public function sensor()
    {
        return $this->belongsTo('App\Sensor');
    }
}
