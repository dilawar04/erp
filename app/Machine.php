<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{

    //protected $table = 'machines';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

    
                    public function machines() {
                    return $this->hasOne('App\machine', 'id', 'machine_id');
                }
                                public function workstations() {
                    return $this->hasOne('App\workstation', 'id', 'workstation_id');
                }
                
}