<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishedProductProfile extends Model
{

    //protected $table = 'finished_product_profiles';
    //public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

 public function workstations()
    {
        return $this->hasOne('App\workstation', 'id', 'workstation_id');
    }
    
    public function oems()
    {
        return $this->hasOne('App\oem', 'id', 'oem_id');
    }
    
    public function mode_storages()
    {
        return $this->hasOne('App\modestorage', 'id', 'mode_storage_id');
    }

}
