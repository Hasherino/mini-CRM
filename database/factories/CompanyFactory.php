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
            'logo' => fake()->image(storage_path('app/public'), 100, 100),
            'website' => fake()->domainName(),
        ];
    }
}
