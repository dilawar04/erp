<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenerateOemSchedule extends Model
{

    //protected $table = 'ganerate_oem_schedules';
    public $timestamps = true;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    public function oems()
    {
        return $this->hasOne('App\oem', 'id', 'oem_id');
    }

}
