<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
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
   // CompanyFactory.php
public function definition()
{
    return [
        'name' => $this->faker->company,
        'location' => $this->faker->city,
        'description' => $this->faker->paragraph,
        'company_capacity' => $this->faker->numberBetween(10, 1000),
        'working_hours' => $this->faker->time('H:i'),
        'image' => $this->faker->imageUrl(),
        'user_id' => User::factory(),
        'category_id' => Category::factory(),
    ];
}
}
