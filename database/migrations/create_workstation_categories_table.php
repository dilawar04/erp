<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkstationCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('workstation_categories')) {
            Schema::create('workstation_categories', function (Blueprint $table) {
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
        Schema::dropIfExists('workstation_categories');
    }
}
