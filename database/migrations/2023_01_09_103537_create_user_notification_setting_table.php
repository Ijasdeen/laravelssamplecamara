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
        Schema::create('user_notification_setting', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('event', array('on', 'off'))->default('on');
            $table->enum('calendar_event', array('on', 'off'))->default('on');
            $table->enum('news_letter', array('on', 'off'))->default('on');
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
        Schema::dropIfExists('user_notification_setting');
    }
};
