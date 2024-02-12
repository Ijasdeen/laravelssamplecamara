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
        Schema::create('newsletter', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
           
            $table->string('title');
            $table->longText('description');  

            $table->string('image');
  
            $table->timestamps();
            $table->enum('status', array('0','1','2'))->default('1')->comment('0-Pending,1-Active,2-Delete');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter');
    }
};
