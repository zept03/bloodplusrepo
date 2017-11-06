<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReactionsPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reactions_post');
        Schema::create('reactions_post', function (Blueprint $table) {

            $table->string('post_id');
            $table->string('reaction_id');
            $table->string('initiated_by');
            $table->index('post_id');
            $table->index('reaction_id');
            $table->index('initiated_by');
            $table->primary(['post_id','reaction_id']);
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
        Schema::dropIfExists('reactions_post');
    }
}
