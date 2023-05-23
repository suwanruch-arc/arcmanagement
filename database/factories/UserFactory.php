<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $partner_id = rand(1, 2);
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'contact_number' => $this->faker->phoneNumber(),
            'username' => $this->faker->unique()->userName(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'partner_id' => $partner_id,
            'department_id' => $partner_id  == 1 ? rand(1, 2) : rand(3, 6),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
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
