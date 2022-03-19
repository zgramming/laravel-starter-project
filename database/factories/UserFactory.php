<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'username'=> 'superadmin',
            'name' => "Super Admin",
            'email' => "superadmin@gmail.com",
            'email_verified_at' => now(),
            'password' => "superadmin", // password
            'remember_token' => Str::random(10),
            'app_group_user_id' => 1,
            'status'=> 'active',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
