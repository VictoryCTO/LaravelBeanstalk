<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('post_id');
            $table->integer('author_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->string('header_image')->nullable();
            $table->text('body');
            $table->foreign('author_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('related_posts', function (Blueprint $table) {
            $table->increments('related_post_id');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('related_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('post_id')->on('posts');
            $table->foreign('related_id')->references('post_id')->on('posts');
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
        Schema::drop('related_posts');
        Schema::drop('posts');
    }
}
