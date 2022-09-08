<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'email' => fake()->unique()->safeEmail(),
            'logo' => fake()->imageUrl($width = 640, $height = 480),
            'website' => fake()->domainName(),
        ];
    }
}
