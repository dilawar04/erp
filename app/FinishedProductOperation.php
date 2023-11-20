<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishedProductOperation extends Model
{

    protected $table = 'finished_product_operations';
    //public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];
    
     public function workstation_operations() {
        return $this->hasOne('App\WorkstationOperation', 'id', 'workstation_operation_id');
    }
    
    
}