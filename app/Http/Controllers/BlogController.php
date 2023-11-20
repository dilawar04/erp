<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rel_type = getUri(2);
        $slug = getUri(3);

        $SQL = \App\BlogPost::where(['blog_posts.status' => 'Published'])
            ->selectRaw('blog_posts.id,
             -- blog_categories.id as category_id,
             blog_posts.author,
             blog_posts.datetime,
             blog_posts.title,
             blog_posts.slug,
             blog_posts.content,
             blog_posts.params,
             blog_posts.views,
             blog_posts.featured_image');
        $limit = opt('posts_per_page') ?? 12;


        if(in_array($rel_type, ['category'])){
            $SQL = $SQL->join('blog_relations', function ($join) {
                $join->on('blog_posts.id', '=', 'blog_relations.post_id')->where('blog_relations.rel_type', '=', 'category');
            })
            ->join('blog_categories', 'blog_categories.id', '=', 'blog_relations.id');
            $SQL = $SQL->where(['blog_categories.slug' => $slug]);
        }
        $rows = $SQL->paginate($limit);

        \App\Theme::template($page->template ?? 'default');
        return \App\Theme::view('blog.index', compact('rows'));
    }

    public function detail($slug)
    {
        $blog = \App\BlogPost::posts(['blog_posts.slug' => $slug, 'blog_posts.status' => 'Published'])->selectRaw('blog_posts.*, GROUP_CONCAT(blog_categories.id) as categories_ids')->first();
        if(!$blog){
            dd("404");
        }
        $blog->views += 1;
        $blog->save();

        $blog->params = json_decode($blog->params);

        \App\Theme::template($page->template ?? 'default');
        return \App\Theme::view('blog.detail', compact('blog'));
    }
}
