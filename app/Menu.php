<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'menus';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    /*public function menus()
    {
        return $this->hasOne('App\menu', 'id', 'parent_id');
    }*/

    public function menu_types()
    {
        return $this->hasOne('App\menu_type', 'id', 'menu_type_id');
    }
}
