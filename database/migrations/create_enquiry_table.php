<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if (!Schema::hasTable('enquiry')) {
            Schema::create('enquiry', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

    $table->Increments("id", 11);
$table->string("name", 100)->nullable();
$table->string("email", 150)->nullable();
$table->string("message")->nullable();
$table->string("status")->nullable()->default('Inactive');
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
        Schema::dropIfExists('enquiry');
    }
}