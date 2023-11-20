<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftOvertimeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if (!Schema::hasTable('shift_overtimes')) {
            Schema::create('shift_overtimes', function (Blueprint $table) {
                $table->engine = env('DATABASE_ENGINE');

    $table->Increments("id", 11);
$table->string("shift_name", 50)->nullable();
$table->string("start_time")->nullable();
$table->string("end_time")->nullable();
$table->string("late_till")->nullable();
$table->string("half_day_from", 50)->nullable();
$table->string("brake_name", 50)->nullable();
$table->string("b_from", 50)->nullable();
$table->string("b_till")->nullable();
$table->string("days", 255)->nullable();
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
        Schema::dropIfExists('shift_overtimes');
    }
}
