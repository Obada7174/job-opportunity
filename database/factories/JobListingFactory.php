<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobListing>
 */
class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // JobListingFactory.php
public function definition()
{
    return [
        'title' => $this->faker->jobTitle,
        'description' => $this->faker->paragraph,
        'salary' => $this->faker->randomFloat(2, 1000, 10000),
        'location' => $this->faker->randomElement(['remote', 'in_company']),
        'working_hours' => $this->faker->time('H:i'),
        'experience' => $this->faker->word,
        'job_title' => $this->faker->jobTitle,
        'company_id' => Company::factory(),
        'category_id' => Category::factory(),
    ];
}
}
