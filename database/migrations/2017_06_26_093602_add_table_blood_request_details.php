<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableBloodRequestDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_request_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bloodtype_id')->nullable();
            $table->integer('units');
            $table->enum('blood_type',
                ['A+','A-','B+','B-','AB+','AB-','O+','O-'
                ]);
            $table->enum('blood_category',
                ['White Blood', 'Platelet', 'Washed RBC','Packed RBC', 'Cryoprecipitate', 'Fresh Frozen Plasma'
                ]);
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
        Schema::dropIfExists('blood_request_details');
    }
}
