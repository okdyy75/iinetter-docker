<?php

namespace Database\Factories;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TweetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tweet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'ref_tweet_id' => null,
            'tweet_type' => $this->faker->randomElement(['tweet', 'retweet', 'reply']),
            'tweet_text' => $this->faker->word,
            'reply_count' => $this->faker->randomDigitNotNull,
            'retweet_count' => $this->faker->randomDigitNotNull,
            'favorite_count' => $this->faker->randomDigitNotNull,
        ];
    }
}
