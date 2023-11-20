<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if (!Schema::hasTable('blog_posts')) {
            Schema::create('blog_posts', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

    $table->Increments("id", 11);
$table->integer("author", 11)->nullable();
$table->string("datetime")->nullable();
$table->string("title", 255)->nullable();
$table->string("slug", 255)->nullable();
$table->string("content")->nullable();
$table->string("status", 20)->nullable();
$table->string("comment_status", 20)->nullable();
$table->string("post_name", 255)->nullable();
$table->string("modified")->nullable()->default('CURRENT_TIMESTAMP');
$table->integer("ordering", 11)->nullable();
$table->string("featured_image", 255)->nullable();
            //$table->timestamps();
//$table->softDeletes();            //$table->softDeletes();
            });
        }
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}