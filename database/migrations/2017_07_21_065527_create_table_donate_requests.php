<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDonateRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donate_requests', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('initiated_by');
            $table->datetime('appointment_time')->nullable(); // null if response
            $table->integer('institution_id'); 
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
        Schema::table('donate_requests', function (Blueprint $table) {
            Schema::dropIfExists('donate_requests');
        });
    }
}
