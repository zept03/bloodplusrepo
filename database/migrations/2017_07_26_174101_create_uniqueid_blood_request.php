<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueidBloodRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('blood_request_details', function (Blueprint $table) {
        //     $table->dropForeign('blood_request_details_blood_request_id_foreign');
        //     $table->dropIndex('blood_request_details_blood_request_id_foreign');
        //     $table->dropColumn('blood_request_id');
        //     // $table->string('id')->primary();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            //
        });
    }
}
