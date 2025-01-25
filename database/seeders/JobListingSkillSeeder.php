<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Controllers;
use App\Models\JobListing;
use App\Models\Skill;
class JobListingSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // الحصول على الوظائف والمهارات
        $jobListings = JobListing::all();
        $skills = Skill::all();

        // إضافة مهارات عشوائية إلى الوظائف
        $jobListings->each(function ($jobListing) use ($skills) {
            $jobListing->skills()->attach(
                $skills->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
