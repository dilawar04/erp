<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationProcessParameter extends Model
{

    //protected $table = 'operation_process_parameters';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

    
                    public function products() {
                    return $this->hasOne('App\product', 'id', 'product_id');
                }
                                public function workstations() {
                    return $this->hasOne('App\workstation', 'id', 'workstation_id');
                }
                                public function oprations() {
                    return $this->hasOne('App\opration', 'id', 'opration_id');
                }
                
}