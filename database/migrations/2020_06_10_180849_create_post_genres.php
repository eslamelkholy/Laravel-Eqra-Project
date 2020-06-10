<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostGenres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_genres', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("genre_id");
            $table->unsignedBigInteger("post_id");
            $table->foreign("genre_id")->references("id")->on("genres")->onDelete('cascade');
            $table->foreign("post_id")->references("id")->on("posts")->onDelete('cascade');
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
        Schema::dropIfExists('post_genres');
    }
}
