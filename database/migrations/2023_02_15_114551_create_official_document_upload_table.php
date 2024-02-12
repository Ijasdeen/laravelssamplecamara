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
        Schema::create('official_document_upload', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('official_document_id');
            $table->foreign('official_document_id')->references('id')->on('official_document')->onDelete('cascade')->onUpdate('cascade');
          
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
           
            $table->string('document');
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
        Schema::dropIfExists('official_document_upload');
    }
};
