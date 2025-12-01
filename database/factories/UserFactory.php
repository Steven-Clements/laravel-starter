<?php

/**
 * Greenhouse
 * —————————————————————————————————————————————————————————————————————————————
 * Clementine Technology Solutions LLC. (dba. Clementine Solutions).
 * @author      Steven "Chris" Clements <clements.steven07@outlook.com>
 * @version     1.0.0
 * @since       1.0.0
 * @copyright   © 2025-2026 Clementine Solutions. All Rights Reserved.
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Specifies how fake data should be generated to satisfy the conditions
 * of each property.
 */
class UserFactory extends Factory
{
    /**
     * @param string $password
     * The current password being used by the factory.
     */
    protected static ?string $password;


    /**
     * definition
     * ——————————————————————————————————————————————————————————————————————————
     * Define the model's default state.
     * @return array<string, mixed>
     * An associative array of each property along with the definition of its
     * value.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }


    /**
     * unverified
     * ——————————————————————————————————————————————————————————————————————————
     * Indicates that the model's email address should be unverified.
     * @return static
     * The updated state of the `email_verified_at` property.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
