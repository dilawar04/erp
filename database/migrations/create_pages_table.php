<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = env('DATABASE_ENGINE');

    $table->bigIncrements("id");
        $table->string("url", 200)->nullable()->unique();
        $table->string("title", 200)->nullable();
        $table->bigInteger("parent_id")->nullable();
        $table->string("show_title", 1)->nullable();
        $table->string("tagline", 255)->nullable();
        $table->string("content")->nullable();
        $table->string("meta_title", 255)->nullable();
        $table->string("meta_keywords", 255)->nullable();
        $table->string("meta_description", 255)->nullable();
        $table->string("status")->nullable()->default('Unpublished');
        $table->string("thumbnail", 100)->nullable();
        $table->string("template", 60)->nullable();
        $table->integer("ordering", 11)->nullable();
        $table->string("user_only")->nullable();
        $table->string("params")->nullable();
                    $table->timestamps();            //$table->softDeletes();
            });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}