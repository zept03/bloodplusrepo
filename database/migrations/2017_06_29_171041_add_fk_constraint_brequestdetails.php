<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkConstraintBrequestdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blood_request_details', function (Blueprint $table) {
            // $table->dropColumn('blood_request_id');
            $table->integer('blood_request_id')->unsigned();
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
