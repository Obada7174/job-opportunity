<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    // UserSeeder.php
public function run()
{
    \App\Models\User::factory(10)->create();
}
}