<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeworkTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('ref')->nullable();
            $table->string('state')->default('open'); // open, close
            $table->longText('description') ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('chat_message', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('type')->default('string'); // string, file, etc
            $table->longText('content') ->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('chat_id');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('chat_message_read_user', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('chat_id');
            $table->bigInteger('chat_message_id'); // last message readed
            $table->bigInteger('counter'); // counter of moment readed
        });
        Schema::create('chat_user', function (Blueprint $table) {
            $table->bigInteger('chat_id');
            $table->bigInteger('user_id');
        });
        Schema::create('chat_group', function (Blueprint $table) {
            $table->bigInteger('chat_id');
            $table->bigInteger('group_id');
        });




        Schema::create('homework', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')     ->nullable();
            $table->longText('details') ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homework');
        Schema::dropIfExists('chat');
        Schema::dropIfExists('chat_message');
        Schema::dropIfExists('chat_message_read_user');
        Schema::dropIfExists('chat_user');
        Schema::dropIfExists('chat_group');
    }
}
