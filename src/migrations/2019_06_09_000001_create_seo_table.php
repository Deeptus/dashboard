<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('section')->unique();
            $table->string('image')->nullable();     // og:image
            $table->string('type')->nullable();      // og:type
            $table->json('title')->nullable();       // og:title
            $table->json('description')->nullable(); // og:description
            $table->json('keywords')->nullable();    // meta keywords
            $table->json('author')->nullable();    // meta keywords
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
        Schema::dropIfExists('seo');
    }
}
