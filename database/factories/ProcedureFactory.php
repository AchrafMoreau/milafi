<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cas;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProcedureFactory extends Factory
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
            'cas_id' => Cas::inRandomOrder()->value('id'),
            'date' => $this->faker->date(),
            'procedure' => $this->faker->text(),
            'fee' => $this->faker->randomFloat(2),
            'time' => $this->faker->time(),
            'invoice' => $this->faker->randomFloat(2)
        ];
    }
}
