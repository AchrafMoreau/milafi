<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "name" => $this->faker->name(),
            "phone" => $this->faker->e164PhoneNumber(),
            'user_id' => User::inRandomOrder()->value('id'),
            "email" => $this->faker->email(),
            "address" => $this->faker->address(),
            "avatar" => $this->faker->imageUrl(),
            'tag' => '[]'
        ];
    }
}
