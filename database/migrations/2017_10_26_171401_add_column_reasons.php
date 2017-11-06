<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->text('reason')->nullable();
            $table->string('gender');
            $table->integer('age'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->dropColumn('reason');
        });
    }
}
