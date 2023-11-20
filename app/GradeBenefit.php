<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeBenefit extends Model
{

    //protected $table = 'grade_benefits';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

    
    public function allowance_benefits() {
        return $this->hasOne('App\allowance_benefit', 'id', 'allowance_id');
    }
    
    public function leaves() {
        return $this->hasOne('App\leaf', 'id', 'leaves_id');
    }
                
}