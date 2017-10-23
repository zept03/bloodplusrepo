<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBloodBags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_bags', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('blood_type',
                ['A+','A-','B+','B-','AB+','AB-','O+','O-'
                ]);
            $table->enum('blood_category',
                ['White Blood', 'Platelet', 'Washed RBC','Packed RBC', 'Cryoprecipitate', 'Fresh Frozen Plasma'
                ]);
            $table->integer('quantity');
            $table->integer('emergency_qty');
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
        Schema::dropIfExists('blood_bags');
    }
}
