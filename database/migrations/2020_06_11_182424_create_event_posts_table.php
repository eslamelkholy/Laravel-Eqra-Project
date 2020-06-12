<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_posts', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("event_id");
            $table->unsignedBigInteger("post_id");
            $table->foreign("event_id")->references("id")->on("events")->onDelete('cascade');
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
        Schema::dropIfExists('event_posts');
    }
}
