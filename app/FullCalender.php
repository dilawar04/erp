<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullCalender extends Model
{

    protected $table = 'events';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

    
}