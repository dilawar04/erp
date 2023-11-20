<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{

    protected $table = 'enquiry';
    //public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $fillable = ['name', 'email', 'message'];



}
