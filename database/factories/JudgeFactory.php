<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Court;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Judege>
 */
class JudgeFactory extends Factory
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
            'contact_info' => $this->faker->e164PhoneNumber(),
            'court_id' => Court::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
        ];
    }
}
