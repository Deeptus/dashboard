<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEmailLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // https://github.com/sparksuite/simplemde-markdown-editor
        // https://stackoverflow.com/questions/50054158/laravel-php-eval-with-blade-compilestring
        // https://stackoverflow.com/questions/39801582/laravel-5-compile-string-and-interpolate-using-blade-api-on-server
        Schema::create('email_layouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->nullable();
            $table->string('description')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
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
        Schema::dropIfExists('email_layouts');
    }
}
