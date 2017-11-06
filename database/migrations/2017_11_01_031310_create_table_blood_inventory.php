<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBloodInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_inventories', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('serial_number')->nullable();
            
            $table->string('screened_blood_id');

            $table->string('blood_type_id');
            $table->datetime('expiry_date');
            
            //sold,available,unavailable
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
        Schema::dropIfExists('blood_inventories');
    }
}
