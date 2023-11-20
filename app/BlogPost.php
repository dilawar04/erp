<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{

    //protected $table = 'blog_posts';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    //protected $perPage = 15;

    protected $guarded = [];


    function posts($where = ['status' => 'Published']){
        $query = self::where($where)
            ->leftJoin('blog_relations', function ($join) {
                $join->on('blog_relations.post_id', '=', 'blog_posts.id')
                    ->where('blog_relations.rel_type', 'category', 'category');
            })
            ->leftJoin('blog_categories', 'blog_categories.id', '=', 'blog_relations.id');
            //\DB::raw('blog_posts.*, blog_categories.category, blog_categories.slug as cat_slug')
        return $query;
    }

}
