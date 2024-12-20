<?php

namespace Database\Seeders;

use App\Models\Exercise\Exercise;
use App\Models\Role;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory(3)->create();
        User::factory(10)->create();
        TrainingPlan::factory(10)->create();
        Exercise::factory(20)->create();
    }
}
