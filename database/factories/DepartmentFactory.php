<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $job = $this->faker->jobTitle;
        return [
            'name' => $job,
            'keyword' => str_replace(' ', '_', substr(strtolower($job), 0, 9))
        ];
    }
}
