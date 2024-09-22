<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cas;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            "description" => $this->faker->text(),
            'dueDate'=> $this->faker->date(),
            'user_id' => User::inRandomOrder()->value('id'),
            'status' => $this->faker->randomElement(['Completed', 'Inprogress', 'New', 'Pending']),
            'priority' => $this->faker->randomElement(['High', 'Low', 'Medium']),
        ];
    }
}
