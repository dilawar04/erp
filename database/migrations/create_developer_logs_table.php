<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeveloperLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_logs', function (Blueprint $table) {
            $table->engine = env('DATABASE_ENGINE');

            $table->bigIncrements("id");
            $table->string("type", 100)->nullable();
            $table->string("description")->nullable();
            $table->string("table", 100)->nullable();
            $table->bigInteger("table_id")->nullable();
            $table->integer("user_id", 11)->nullable();
            $table->string("user_ip", 50)->nullable();
            $table->string("user_agent", 255)->nullable();
            $table->string("current_URL", 255)->nullable();
            $table->string("status")->nullable()->default('Pending');
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('developer_logs');
    }
}
