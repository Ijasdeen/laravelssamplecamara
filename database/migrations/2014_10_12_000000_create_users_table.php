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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('email')->unique();
            $table->string('phoneno')->unique();
            $table->string('occupation')->nullable();
            $table->string('age')->nullable();
            $table->string('password');
            $table->string('user_image')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->text('device_token');
            /* Users: 0=>User, 1=>Admin*/ 
            $table->timestamps();
            $table->enum('status', array('0','1'))->default('0')->comment('0-Block,1-Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
