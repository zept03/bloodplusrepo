<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeDonaterequestAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donate_requests', function (Blueprint $table) {
            $table->dropColumn('appointment_time');
            // $table->timestamp('appointment_time')->nullable();
            // $table->timestamp('appointment_time')->default(DB::raw('CURRENT_TIMESTAMP'));
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
            //
        });
    }
}
