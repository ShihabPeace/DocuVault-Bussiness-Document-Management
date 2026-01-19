<?php

namespace Database\Factories;

use App\Enums\EnumsRoles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        

$bdPhones = [
    '+8801301234567',
    '+8801312345678',
    '+8801323456789',
    '+8801334567890',
    '+8801345678901',
    '+8801356789012',
    '+8801367890123',
    '+8801378901234',
    '+8801389012345',
    '+8801390123456',
];

print_r($bdPhones);

        $roles = EnumsRoles::cases();
        return [
            'firstName' => fake()->name(),
            'lastName' => fake()->name(),
            'phone' => $this->faker->randomElement($bdPhones),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => $roles[array_rand($roles)]->value,
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
