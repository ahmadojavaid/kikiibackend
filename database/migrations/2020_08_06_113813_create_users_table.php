<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->boolean('phone_verified')->default(0);
            $table->string('role')->default('user');
            $table->string('profile_pic')->nullable();
            $table->string('birthday')->nullable();
            $table->boolean('profile_verified')->default(0);
            $table->string('gender_identity')->nullable();
            $table->string('sexual_identity')->nullable();
            $table->string('pronouns')->nullable();
            $table->text('bio')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('height')->nullable();
            $table->string('looking_for')->nullable();
            $table->string('drink')->nullable();
            $table->string('smoke')->nullable();
            $table->string('cannabis')->nullable();
            $table->string('political_views')->nullable();
            $table->string('religion')->nullable();
            $table->string('diet_like')->nullable();
            $table->string('sign')->nullable();
            $table->string('pets')->nullable();
            $table->string('kids')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->timestamp('last_online')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('auth_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
