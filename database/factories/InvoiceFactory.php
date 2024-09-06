<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as Faker;
use App\Models\Cas;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
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
            'date'=> $this->faker->date(),
            'desc' => $this->faker->sentence(),
            'cas_id' => Cas::inRandomOrder()->value('id'),
            'amount' => $this->faker->randomFloat(2, 5, 100),
            'status' => $this->faker->randomElement(['Paid', 'Unpaid', 'Overdue']),
        ];
    }
}
