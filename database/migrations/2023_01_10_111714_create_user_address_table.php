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
        Schema::create('user_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('address_type', array('home', 'office'))->default('home');
            $table->text('address');
            $table->text('additional_details')->nullable();
            $table->text('latitude');
            $table->text('longitude');
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
        Schema::dropIfExists('user_address');
    }
};
