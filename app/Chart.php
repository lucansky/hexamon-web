<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'charts';

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
    protected $fillable = ['category_name', 'sensor_id', 'min', 'max'];

    public function sensor()
    {
        return $this->belongsTo('App\Sensor');
    }
}
