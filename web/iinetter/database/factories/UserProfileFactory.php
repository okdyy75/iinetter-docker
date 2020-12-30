<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;

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
            'screen_name' => $this->faker->word,
            'description' => $this->faker->word,
            'location' => $this->faker->word,
            'url' => $this->faker->url,
            'icon' => $this->faker->imageUrl,
            'header_image' => $this->faker->imageUrl,
        ];
    }
}
