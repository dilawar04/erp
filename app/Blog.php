<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $table = 'blog_posts';
    //public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /*public function category()
    {
        return $this->hasOne(TeamCategory::class, 'id', 'category_id');
    }*/

}
