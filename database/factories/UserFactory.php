<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = Faker::create('ar_SA');
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'avatar' => $this->faker->imageUrl(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'name_in_arab' => 'ابو حسين حبيب قلبي',
            'city_in_arab' => 'امريكا',
            'city' => $this->faker->city(),
            'role' => $this->faker->randomElement(['Admin', 'Lawyer', 'Assistant']),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10), 
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
