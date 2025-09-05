<?php

namespace Database\Seeders;

use App\Models\ScheduleType;
use Illuminate\Database\Seeder;

class ScheduleTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'name' => 'setoran',
                'display_name' => 'Setoran',
                'description' => 'Setoran hafalan Al-Quran',
                'max_participants' => 30,
                'duration_minutes' => 90,
            ],
            [
                'name' => 'praktek',
                'display_name' => 'Praktek',
                'description' => 'Praktek wudlu dan sholat',
                'max_participants' => 30,
                'duration_minutes' => 60,
            ],
            [
                'name' => 'privat',
                'display_name' => 'Privat',
                'description' => 'Pembelajaran privat/individual',
                'max_participants' => 10,
                'duration_minutes' => 45,
            ],
        ];

        foreach ($types as $type) {
            ScheduleType::create($type);
        }
    }
}