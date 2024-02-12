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
        Schema::create('member_directory', function (Blueprint $table) {
            $table->id(); 
            $table->string('company_name');
            $table->longText('website'); 
            $table->string('image');
            $table->string('email');
            $table->string('contact_no');
            $table->string('poc_name');
            $table->string('sector'); 

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
        Schema::dropIfExists('member_directory');
    }
};
