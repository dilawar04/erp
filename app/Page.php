<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    //protected $table = 'pages';    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    /*public function pages()
    {
        return $this->hasOne('App\page', 'id', 'parent_id');
    }*/
}
