<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = Faker::create('ar_SA');
        return [
            //
            "name" => $this->faker->name(),
            "contact_info" => $this->faker->e164PhoneNumber(),
            "address" => $this->faker->address(),
            "avatar" => $this->faker->imageUrl(),
            'gender'=> $this->faker->randomElement(['male', 'female']),
            'CIN'=> $this->faker->iban(),
        ];
    }
}
