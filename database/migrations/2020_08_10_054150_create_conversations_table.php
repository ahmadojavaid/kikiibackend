<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_1_id');
            $table->unsignedBigInteger('participant_2_id');
            $table->unsignedBigInteger('deleted_by_user_id');
            $table->foreign('participant_1_id')->references('id')->on('users');
            $table->foreign('participant_2_id')->references('id')->on('users');
            $table->foreign('deleted_by_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('conversations');
    }
}
