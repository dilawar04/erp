<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoryTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if (!Schema::hasTable('blog_categories')) {
            Schema::create('blog_categories', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

    $table->Increments("id", 11);
$table->string("category", 255)->nullable();
$table->foreignId("parent_id", 11)->constrained('parents')->nullable();//->onDelete('cascade');
$table->string("slug", 255)->nullable();
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
        Schema::dropIfExists('blog_categories');
    }
}