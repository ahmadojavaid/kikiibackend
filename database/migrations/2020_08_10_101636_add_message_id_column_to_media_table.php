<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageIdColumnToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->unsignedBigInteger('message_id')->after('path')->nullable();
            $table->unsignedBigInteger('conversation_id')->after('message_id')->nullable();
            $table->foreign('message_id')->references('id')->on('messages');
            $table->foreign('conversation_id')->references('id')->on('conversations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropForeign(['message_id', 'conversation_id']);
            $table->dropColumn(['message_id', 'conversation_id']);
        });
    }
}
