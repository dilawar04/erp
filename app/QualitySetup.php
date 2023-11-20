<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualitySetup extends Model
{

    //protected $table = 'quality_setups';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

    
                    public function products() {
                    return $this->hasOne('App\product', 'id', 'product_id');
                }
                                public function workstations() {
                    return $this->hasOne('App\workstation', 'id', 'workstation_id');
                }
                                public function oprations() {
                    return $this->hasOne('App\opration', 'id', 'opration_id');
                }
                                public function quality_defects() {
                    return $this->hasOne('App\quality_defect', 'id', 'quality_defect_id');
                }
                                public function raw_material_categories() {
                    return $this->hasOne('App\raw_material_category', 'id', 'material_id');
                }
                
}