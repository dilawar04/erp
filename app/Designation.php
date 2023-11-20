<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{

    //protected $table = 'designations';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    public function departments()
    {
        return $this->hasOne('App\department', 'id', 'department_id');
    }

}
