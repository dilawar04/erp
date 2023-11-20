<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderManually extends Model
{

    //protected $table = 'delivery_order_manuallies';
    //public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];



 public function oems()
    {
        return $this->hasOne('App\oem', 'id', 'oem_id');
    }

}
