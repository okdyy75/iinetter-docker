<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => str_replace('.', '', $this->faker->unique()->userName),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => $this->faker->date('Y-m-d H:i:s'),
            'password' => Hash::make($this->faker->password),
            'api_token' => hash('sha256', Str::random(60)),
            'remember_token' => Str::random(10),
            'is_admin' => $this->faker->randomElement([true, false]),
        ];
    }
}
