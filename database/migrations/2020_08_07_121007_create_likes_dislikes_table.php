<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesDislikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes_dislikes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('liker_id')->nullable();
            $table->unsignedBigInteger('disliker_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('liker_id')->references('id')->on('users');
            $table->foreign('disliker_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('likes_dislikes');
    }
}
