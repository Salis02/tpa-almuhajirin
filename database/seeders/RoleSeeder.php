<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'ustadz',
                'display_name' => 'Ustadz/Ustadzah',
                'description' => 'Pengajar Al-Quran dan ilmu agama',
            ],
            [
                'name' => 'pengurus',
                'display_name' => 'Pengurus',
                'description' => 'Pengurus harian TPA',
            ],
            [
                'name' => 'komite',
                'display_name' => 'Komite',
                'description' => 'Komite TPA',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}