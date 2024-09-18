<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as Faker;
use App\Models\Cas;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
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
            'cas_id' => Cas::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'file_desc' => $this->faker->text(),
            'file_path' => $this->faker->imageUrl()
        ];
    }
}
