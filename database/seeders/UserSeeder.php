<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Owner
        $owner = User::create([
            'name' => 'Owner Seblak Sulthane',
            'email' => 'owner@seblaksulthane.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);
        $owner->assignRole('owner');

        // Manager Cabang
        $manager_cabang = User::create([
            'name' => 'Manager Cabang Franchise Seblak Sulthane',
            'email' => 'manager@seblaksulthane.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);
        $manager_cabang->assignRole('manager_cabang');

        // Karyawan
        User::create([
            'name' => 'Karyawan Seblak Sulthane',
            'email' => 'karyawan@seblaksulthane.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ])->assignRole('karyawan');
    }
}
