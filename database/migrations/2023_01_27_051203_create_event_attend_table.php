<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_attend', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('event')->onDelete('cascade')->onUpdate('cascade');
          
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        
            $table->timestamps();
            $table->enum('status', array('1','2'))->default('1')->comment('1-attend,2-not_attend');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_attend');
    }
};
