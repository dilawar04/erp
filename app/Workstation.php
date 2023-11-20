<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkStation extends Model
{

    //protected $table = 'work_stations';
    public $timestamps = true;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    public function workstation_categories()
    {
        return $this->hasOne('App\workstation_category', 'id', 'category_id');
    }

}
