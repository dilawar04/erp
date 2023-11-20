<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTypeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if (!Schema::hasTable('content_types')) {
            Schema::create('content_types', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

    $table->Increments("id", 11);
$table->string("title", 150)->nullable();
$table->string("identifier", 150)->nullable();
$table->string("meta_title", 255)->nullable();
$table->string("meta_description", 255)->nullable();
$table->string("meta_keywords", 255)->nullable();
$table->string("robots")->nullable()->default('INDEX,FOLLOW');
$table->string("sitemap")->nullable()->default('Yes');
$table->string("search")->nullable()->default('Yes');
$table->string("layout", 100)->nullable();
$table->string("fileds")->nullable();
$table->string("status")->nullable()->default('Active');
            $table->timestamps();
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
        Schema::dropIfExists('content_types');
    }
}