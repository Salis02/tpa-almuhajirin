<?php

namespace Database\Seeders;

use App\Models\AssessmentCategory;
use App\Models\Assessment;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    public function run()
    {
        // Kategori Akademik
        $akademik = AssessmentCategory::create([
            'name' => 'akademik',
            'display_name' => 'Akademik',
            'description' => 'Penilaian kemampuan akademik Al-Quran',
            'icon' => 'book-open',
            'color' => '#3B82F6',
            'weight' => 60,
        ]);

        // Assessments untuk Akademik
        Assessment::create([
            'assessment_category_id' => $akademik->id,
            'name' => 'tajwid',
            'display_name' => 'Tajwid',
            'description' => 'Kemampuan membaca Al-Quran dengan tajwid yang benar',
            'assessment_type' => 'grade',
            'scale_config' => [
                'grades' => ['A', 'B', 'C', 'D'],
                'descriptions' => [
                    'A' => 'Sangat Baik',
                    'B' => 'Baik', 
                    'C' => 'Cukup',
                    'D' => 'Perlu Perbaikan'
                ]
            ],
            'weight' => 30,
        ]);

        Assessment::create([
            'assessment_category_id' => $akademik->id,
            'name' => 'hafalan',
            'display_name' => 'Hafalan Al-Quran',
            'description' => 'Progress hafalan Al-Quran',
            'assessment_type' => 'numeric',
            'scale_config' => [
                'min' => 0,
                'max' => 30,
                'step' => 1,
                'unit' => 'Juz'
            ],
            'weight' => 40,
        ]);

        Assessment::create([
            'assessment_category_id' => $akademik->id,
            'name' => 'kelancaran',
            'display_name' => 'Kelancaran Bacaan',
            'description' => 'Kelancaran dalam membaca Al-Quran',
            'assessment_type' => 'numeric',
            'scale_config' => [
                'min' => 0,
                'max' => 100,
                'step' => 5
            ],
            'weight' => 30,
        ]);

        // Kategori Akhlak
        $akhlak = AssessmentCategory::create([
            'name' => 'akhlak',
            'display_name' => 'Akhlak',
            'description' => 'Penilaian perilaku dan akhlak sehari-hari',
            'icon' => 'heart',
            'color' => '#10B981',
            'weight' => 40,
        ]);

        // Assessments untuk Akhlak
        $akhlakItems = [
            ['sholat', 'Kedisiplinan Sholat', 'Kedisiplinan dalam melaksanakan sholat 5 waktu'],
            ['adab', 'Adab dan Sopan Santun', 'Perilaku sopan santun terhadap guru dan teman'],
            ['kebersihan', 'Kebersihan', 'Menjaga kebersihan diri dan lingkungan'],
            ['kejujuran', 'Kejujuran', 'Berperilaku jujur dalam perkataan dan perbuatan'],
            ['kerjasama', 'Kerjasama', 'Kemampuan bekerja sama dengan teman'],
        ];

        foreach ($akhlakItems as $item) {
            Assessment::create([
                'assessment_category_id' => $akhlak->id,
                'name' => $item[0],
                'display_name' => $item[1],
                'description' => $item[2],
                'assessment_type' => 'grade',
                'scale_config' => [
                    'grades' => ['A', 'B', 'C', 'D'],
                    'descriptions' => [
                        'A' => 'Sangat Baik',
                        'B' => 'Baik',
                        'C' => 'Cukup', 
                        'D' => 'Perlu Perbaikan'
                    ]
                ],
                'weight' => 20,
            ]);
        }
    }
}