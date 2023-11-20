<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_template', function (Blueprint $table) {
            $table->engine = env('DATABASE_ENGINE');

            $table->Increments("msg_id", 11);
            $table->string("lang_code", 4)->nullable()->default('en');
            $table->string("title", 255)->nullable();
            $table->string("subject", 255)->nullable();
            $table->string("message")->nullable();
            //$table->timestamps();
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
        Schema::dropIfExists('message_template');
    }
}
