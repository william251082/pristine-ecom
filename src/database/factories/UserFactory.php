<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class UserFactory extends Factory
{
    #[ArrayShape([
        'name' => "string",
        'email' => "string",
        'email_verified_at' => "\Illuminate\Support\Carbon",
        'password' => "string",
        'remember_token' => "string",
        'verified' => "mixed",
        'verification_token' => "null|string",
        'admin' => "mixed"
    ])]
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'verified' => $verified = fake()->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
            'verification_token' => $verified === User::VERIFIED_USER ? null : User::generateVerificationCode(),
            'admin' => fake()->randomElement([User::ADMIN_USER, User::REGULAR_USER])
        ];
    }

    public function unverified(): UserFactory
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
