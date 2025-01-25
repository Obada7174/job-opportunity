<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // DatabaseSeeder.php
public function run()
{
    $this->call([
        SkillSeeder::class,
        UserSeeder::class,
        CategorySeeder::class,
        CompanySeeder::class,
        JobListingSeeder::class,
        SubmissionSeeder::class,
    ]);
}
}
