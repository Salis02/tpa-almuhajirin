<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TpaClass;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'name' => 'abu-bakar',
                'display_name' => 'Abu Bakar',
                'description' => 'Kelas untuk santri lanjutan (setoran)',
                'capacity' => 50,
            ],
            [
                'name' => 'umar',
                'display_name' => 'Umar',
                'description' => 'Kelas untuk santri menengah (praktek & privat)',
                'capacity' => 50,
            ],
            [
                'name' => 'usman',
                'display_name' => 'Usman',
                'description' => 'Kelas untuk santri pertama (praktek & privat)',
                'capacity' => 50,
            ],
        ];

        foreach ($classes as $class) {
            TpaClass::create($class);
        }
    }
}
