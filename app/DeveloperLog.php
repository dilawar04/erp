<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeveloperLog extends Model
{
    //protected $perPage = 15;

    protected $guarded = [];

    
                public function users() {
                return $this->hasOne('App\user', 'id', 'user_id');
            }
            }