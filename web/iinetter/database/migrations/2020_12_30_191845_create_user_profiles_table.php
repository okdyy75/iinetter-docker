<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigInteger('id', true, true);
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('screen_name')->nullable();
            $table->string('description')->nullable();
            $table->string('location')->nullable();
            $table->text('url')->nullable();
            $table->text('icon')->nullable();
            $table->text('header_image')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_profiles');
    }
}
