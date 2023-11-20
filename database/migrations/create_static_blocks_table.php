<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticBlockTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('static_blocks', function (Blueprint $table) {
            $table->engine = env('DATABASE_ENGINE');

    $table->bigIncrements("id");
        $table->string("title", 255)->nullable();
        $table->string("identifier", 100)->nullable()->unique();
        $table->string("content")->nullable();
        $table->string("status")->nullable()->default('Active');
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
        Schema::dropIfExists('static_blocks');
    }
}