<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestIdBloodRequestDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blood_request_details', function (Blueprint $table) {
            // $table->string('blood_request_id');
            $table->foreign('blood_request_id')
              ->references('id')->on('blood_requests')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blood_request_details', function (Blueprint $table) {
            //
        });
    }
}
