<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriberTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if (!Schema::hasTable('subscribers')) {
            Schema::create('subscribers', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

    $table->bigIncrements("id");
$table->string("email", 255)->nullable()->unique();
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
        Schema::dropIfExists('subscribers');
    }
}