<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderManualy extends Model
{

    //protected $table = 'purchase_order_manualies';
    //public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

 public function suppliers()
    {
        return $this->hasOne('App\supplier', 'id', 'supplier_id');
    }

}
