<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClassSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ScheduleTypeSeeder::class,
            AssessmentSeeder::class,
            SantriSeeder::class,
        ]);
    }
}
