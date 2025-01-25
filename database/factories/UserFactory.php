<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // كلمة مرور افتراضية
            'role' => $this->faker->randomElement(['user', 'admin', 'company_owner']),
            'last_name' => $this->faker->lastName(),
            'phone_number' => $this->faker->phoneNumber(),
            'location' => $this->faker->city(),
            'cv_file_path' => $this->faker->filePath(),
            'image' => $this->faker->imageUrl(),
            'certificates' => $this->faker->words(3, true), // 3 شهادات عشوائية
            'languages' => $this->faker->words(2, true), // لغتان عشوائيتان
            'portfolio_url' => $this->faker->url(),
            'presentation' => $this->faker->paragraph(),
            'experience' => $this->faker->paragraph(),
            'remember_token' => Str::random(10),
        ];
    }
}