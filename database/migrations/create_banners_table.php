<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->engine = env('DATABASE_ENGINE');

            $table->Increments("id", 11);
            $table->string("image", 255)->nullable();
            $table->string("title", 255)->nullable();
            $table->string("type")->nullable()->default('Static');
            $table->integer("rel_id", 11)->nullable();
            $table->string("link", 255)->nullable();
            $table->integer("ordering", 6)->nullable()->default('1');
            $table->string("status")->nullable()->default('Active');
            $table->string("description")->nullable();
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
        Schema::dropIfExists('banners');
    }
}
