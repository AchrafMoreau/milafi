<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Client;
use App\Models\User;
use App\Models\Court;
use App\Models\Judge;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cas>
 */
class CasFactory extends Factory
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
            'client_id'=> Client::inRandomOrder()->value('id'),
            'serial_number'=> $this->faker->numerify('#####'),
            'title_file' => $this->faker->sentence(3),
            'title_number' => $this->faker->randomNumber(6, true),
            'status' => $this->faker->randomElement(['Open', 'Closed', 'Pending']),
            'court_id' => Court::inRandomOrder()->value('id'),
            'judge_id' => Judge::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'report_number' => $this->faker->randomNumber(6, true),
            'execution_number' => $this->faker->randomNumber(6, true),
            'report_file' => $this->faker->name(),
            'execution_file' => $this->faker->name(),
            'opponent' => $this->faker->username(),
        ];
    }
}
