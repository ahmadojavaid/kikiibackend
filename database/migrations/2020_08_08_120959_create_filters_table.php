<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('distance')->nullable();
            $table->string('height')->nullable();
            $table->string('gender_identity')->nullable();
            $table->string('sexual_identity')->nullable();
            $table->string('pronouns')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('diet_like')->nullable();
            $table->string('sign')->nullable();
            $table->string('looking_for')->nullable();
            $table->string('drink')->nullable();
            $table->string('cannabis')->nullable();
            $table->string('political_views')->nullable();
            $table->string('religion')->nullable();
            $table->string('pets')->nullable();
            $table->string('kids')->nullable();
            $table->string('smoke')->nullable();
            $table->string('last_online')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('filters');
    }
}
