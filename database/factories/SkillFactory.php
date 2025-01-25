<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word, // إنشاء اسم مهارة عشوائي وفريد
        ];
    }
}