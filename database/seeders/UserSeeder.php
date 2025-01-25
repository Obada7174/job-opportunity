<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    // UserSeeder.php
    public function run()
    {
        // إنشاء 5 مستخدمين وهميين
        User::factory()->count(5)->create()->each(function ($user) {
            // إضافة 3 مهارات عشوائية إلى كل مستخدم
            $skills = Skill::inRandomOrder()->limit(3)->pluck('id');
            $user->skills()->attach($skills);
        });
    }
}