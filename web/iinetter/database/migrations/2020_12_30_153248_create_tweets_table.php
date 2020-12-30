<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->bigInteger('id', true, true);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('ref_tweet_id')->unsigned()->nullable();
            $table->enum('tweet_type', ['tweet','retweet','reply']);
            $table->string('tweet_text')->nullable();
            $table->integer('reply_count')->default(0);
            $table->integer('retweet_count')->default(0);
            $table->integer('favorite_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ref_tweet_id')->references('id')->on('tweets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tweets');
    }
}
