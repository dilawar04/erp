<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkstationOperation extends Model
{

    //protected $table = 'workstation_operations';
    public $timestamps = true;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    public function workstations()
    {
        return $this->hasOne('App\workstation', 'id', 'workstation_id');
    }

}
