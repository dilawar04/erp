<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineMaintanence extends Model
{

    protected $table = 'machine_maintanence';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

    
                    public function machines() {
                    return $this->hasOne('App\machine', 'id', 'machine_id');
                }
                
}