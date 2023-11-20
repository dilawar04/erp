<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('units')) {
            Schema::create('units', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

                $table->Increments("id", 11);
                $table->string("title")->nullable();
                $table->string("code")->nullable();
                $table->foreignId("user_id", 11)->constrained('users')->nullable();//->onDelete('cascade');
                $table->string("status")->nullable()->default('Active');
                $table->timestamps();
                $table->softDeletes();            //$table->softDeletes();
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
        Schema::dropIfExists('units');
    }
}
