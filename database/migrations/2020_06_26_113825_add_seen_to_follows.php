<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeenToFollows extends Migration
{
    public function up()
    {
        Schema::table('follows', function (Blueprint $table) {
            $table->boolean('seen')->default(false);
        });
    }
    public function down()
    {
        Schema::table('follows', function (Blueprint $table) {
            $table->dropColumn('seen');
        });
    }
}
