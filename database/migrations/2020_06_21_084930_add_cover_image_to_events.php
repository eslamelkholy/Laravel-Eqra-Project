<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoverImageToEvents extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string("cover_image")->nullable(true);
        });
    }
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn("cover_image");
        });
    }
}
