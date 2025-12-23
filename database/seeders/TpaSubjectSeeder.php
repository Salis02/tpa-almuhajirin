<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TpaSubject;

class TpaSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Tahsin', 'category' => 'Al-Qur\'an', 'order_index' => 1],
            ['name' => 'Khot', 'category' => 'Al-Qur\'an', 'order_index' => 2],
            ['name' => 'Hafalan', 'category' => 'Al-Qur\'an', 'order_index' => 3],
            ['name' => 'Praktek Sholat', 'category' => 'Ibadah', 'order_index' => 4],
            ['name' => 'Praktek Wudhu', 'category' => 'Ibadah', 'order_index' => 5],
            ['name' => 'Aqidah & Doa Sehari-hari', 'category' => 'Aqidah', 'order_index' => 6],
            ['name' => 'Qiro\'ah / Ayat Pilihan', 'category' => 'Al-Qur\'an', 'order_index' => 7],
            ['name' => 'Tajwid', 'category' => 'Al-Qur\'an', 'order_index' => 8],
            ['name' => 'Bahasa Arab', 'category' => 'Bahasa', 'order_index' => 9],
        ];

        foreach ($subjects as $subject) {
            TpaSubject::firstOrCreate(
                ['name' => $subject['name']],
                $subject
            );
        }
    }
}
