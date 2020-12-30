<?php namespace Tests\Repositories;

use App\Models\Tweet;
use App\Repositories\TweetRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TweetRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TweetRepository
     */
    protected $tweetRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->tweetRepo = \App::make(TweetRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tweet()
    {
        $tweet = Tweet::factory()->make()->toArray();

        $createdTweet = $this->tweetRepo->create($tweet);

        $createdTweet = $createdTweet->toArray();
        $this->assertArrayHasKey('id', $createdTweet);
        $this->assertNotNull($createdTweet['id'], 'Created Tweet must have id specified');
        $this->assertNotNull(Tweet::find($createdTweet['id']), 'Tweet with given id must be in DB');
        $this->assertModelData($tweet, $createdTweet);
    }

    /**
     * @test read
     */
    public function test_read_tweet()
    {
        $tweet = Tweet::factory()->create();

        $dbTweet = $this->tweetRepo->find($tweet->id);

        $dbTweet = $dbTweet->toArray();
        $this->assertModelData($tweet->toArray(), $dbTweet);
    }

    /**
     * @test update
     */
    public function test_update_tweet()
    {
        $tweet = Tweet::factory()->create();
        $fakeTweet = Tweet::factory()->make()->toArray();

        $updatedTweet = $this->tweetRepo->update($fakeTweet, $tweet->id);

        $this->assertModelData($fakeTweet, $updatedTweet->toArray());
        $dbTweet = $this->tweetRepo->find($tweet->id);
        $this->assertModelData($fakeTweet, $dbTweet->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tweet()
    {
        $tweet = Tweet::factory()->create();

        $resp = $this->tweetRepo->delete($tweet->id);

        $this->assertTrue($resp);
        $this->assertNull(Tweet::find($tweet->id), 'Tweet should not exist in DB');
    }
}
