<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\JobListing;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // SubmissionFactory.php
public function definition()
{
    return [
        'user_id' => User::factory(),
        'job_id' => JobListing::factory(),
        'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        'applied_at' => $this->faker->dateTimeThisYear,
    ];
}
}
