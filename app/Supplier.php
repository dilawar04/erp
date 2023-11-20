<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $table = 'suppliers';
    //public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];
    
     public function raw_material_profiles() {
        return $this->hasOne('App\RawMaterialProfile', 'id', 'raw_material_profile_id');
    }
    
    
}