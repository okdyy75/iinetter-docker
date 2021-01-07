<?php namespace Tests\APIs\LoginUser;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tweet;
use App\Models\User;

class TweetAPITest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tweet()
    {
        $user = User::factory()->create();
        $tweet = Tweet::factory()->make(['user_id' => $user->id, 'tweet_type' => 'tweet'])->toArray();

        $this->response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/v1/tweets', $tweet
        );

        $this->assertApiResponse($tweet);
    }

    /**
     * @test
     */
    public function test_update_tweet()
    {
        $user = User::factory()->create();
        $tweet = Tweet::factory()->create(['user_id' => $user->id, 'tweet_type' => 'tweet']);
        $editedTweet = Tweet::factory()->make()->only(['favorite_count']);

        $this->response = $this->actingAs($user, 'api')->json(
            'PATCH',
            '/api/v1/tweets/'.$tweet->id,
            $editedTweet
        );

        $this->assertApiResponse($editedTweet);
    }

    /**
     * @test
     */
    public function test_delete_tweet()
    {
        $user = User::factory()->create();
        $tweet = Tweet::factory()->create([
            'user_id' => $user->id
        ]);

        $this->response = $this->actingAs($user, 'api')->json(
            'DELETE',
             '/api/v1/tweets/'.$tweet->id
         );

        $this->assertApiSuccess();
        $this->response = $this->actingAs($user, 'api')->json(
            'DELETE',
            '/api/v1/tweets/'.$tweet->id
        );

        $this->response->assertStatus(404);
    }
}
