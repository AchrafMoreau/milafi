<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Court>
 */
class CourtFactory extends Factory
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

            'name' => $this->faker->name(),
            'location' => $this->faker->streetAddress(),
            'category' => $this->faker->randomElement(['cassation', 'appel', 'première instance', 'Centres des juges résidents', 'appel de commerce', 'commerciaux', 'appel administratives', 'administratifs']),
        ];
    }
}
