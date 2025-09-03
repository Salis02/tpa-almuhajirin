<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ustadz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin TPA',
            'email' => 'admin@tpa-almuhajirin.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Sample Ustadz
        $ustadzUser = User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ahmad@tpa-almuhajirin.id',
            'password' => Hash::make('ustadz123'),
            'role' => 'ustadz',
            'is_active' => true,
        ]);

        // Create Ustadz Profile
        Ustadz::create([
            'user_id' => $ustadzUser->id,
            'nip' => 'UST001',
            'full_name' => 'Ahmad Suryanto, S.Pd.I',
            'gender' => 'L',
            'birth_date' => '1985-06-15',
            'birth_place' => 'Yogyakarta',
            'address' => 'Jl. Kaliurang KM 5, Yogyakarta',
            'phone' => '081234567890',
            'email' => 'ahmad@tpa-almuhajirin.id',
            'education_level' => 'S1',
            'education_major' => 'Pendidikan Agama Islam',
            'certification' => 'Sertifikat Tahfidz Al-Quran',
            'join_date' => '2020-01-15',
            'employment_status' => 'tetap',
            'status' => 'active',
        ]);

        // Sample Ustadzah
        $ustadzahUser = User::create([
            'name' => 'Ustadzah Fatimah',
            'email' => 'fatimah@tpa-almuhajirin.id',
            'password' => Hash::make('ustadz123'),
            'role' => 'ustadz',
            'is_active' => true,
        ]);

        Ustadz::create([
            'user_id' => $ustadzahUser->id,
            'nip' => 'UST002',
            'full_name' => 'Fatimah Az-Zahra, S.Pd.I',
            'gender' => 'P',
            'birth_date' => '1990-03-20',
            'birth_place' => 'Solo',
            'address' => 'Jl. Malioboro No. 15, Yogyakarta',
            'phone' => '081234567891',
            'email' => 'fatimah@tpa-almuhajirin.id',
            'education_level' => 'S1',
            'education_major' => 'Pendidikan Agama Islam',
            'certification' => 'Sertifikat Qiroah',
            'join_date' => '2021-08-01',
            'employment_status' => 'tetap',
            'status' => 'active',
        ]);
    }
}