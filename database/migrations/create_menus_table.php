<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = env('DATABASE_ENGINE');

    $table->Increments("id", 11);
        $table->integer("parent_id", 11)->nullable();
        $table->string("menu_title", 255)->nullable();
        $table->string("menu_link", 255)->nullable();
        $table->string("menu_type", 50)->nullable()->default('custom');
        $table->integer("menu_type_id", 11)->nullable();
        $table->string("ordering", 3)->nullable();
        $table->string("params")->nullable();
        $table->string("status")->nullable()->default('active');
                    //$table->timestamps();            //$table->softDeletes();
            });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}