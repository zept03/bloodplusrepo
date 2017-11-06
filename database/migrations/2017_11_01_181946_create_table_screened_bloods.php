<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableScreenedBloods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screened_bloods', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('serial_number')->nullable();
            $table->string('donate_id');
            //karmi, terumo
            $table->string('bag_type');
            //450s,450d,450q...
            $table->string('bag_component');

            //reactive, non-reactive
            $table->string('reactive')->nullable();

            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('screened_bloods');
    }
}
