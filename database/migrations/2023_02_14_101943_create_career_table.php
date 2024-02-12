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
        Schema::create('career', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
           
            $table->string('title');
            $table->longText('description'); 
            $table->date('career_date'); 
            $table->string('company_name');

            $table->decimal('pay_scale',9,2);

            $table->string('email'); 
 

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
        Schema::dropIfExists('career');
    }
};
