<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

    $table->Increments("id", 11);
$table->foreignId("user_id", 11)->constrained('users')->nullable();//->onDelete('cascade');
$table->string("ip", 50)->nullable();
$table->string("user_agent", 255)->nullable();
$table->string("rating", 2)->nullable();
$table->string("title", 255)->nullable();
$table->string("review")->nullable();
$table->string("nickname", 255)->nullable();
$table->string("posted_at")->nullable()->default('CURRENT_TIMESTAMP');
$table->string("status")->nullable()->default('Pending');
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
        Schema::dropIfExists('reviews');
    }
}