<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'alamat' => 'Jl. Rumah Sakit No. 1, Jakarta',
            'no_ktp' => '1234567890123456',
            'no_hp' => '081234567890',
        ]);

        // Dokter 1 - Poli Umum (id 1)
        User::create([
            'nama' => 'Budi Santoso',
            'email' => 'drbudi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'alamat' => 'Jl. Dokter No. 1, Jakarta',
            'no_ktp' => '2345678901234567',
            'no_hp' => '081234567891',
            'id_poli' => 1,
        ]);

        // Dokter 2 - Poli Anak (id 2)
        User::create([
            'nama' => 'Siti Rahayu',
            'email' => 'drgsiti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'alamat' => 'Jl. Dokter No. 2, Jakarta',
            'no_ktp' => '3456789012345678',
            'no_hp' => '081234567892',
            'id_poli' => 2,
        ]);

        // Pasien 1
        User::create([
            'nama' => 'Rina Marlina',
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'alamat' => 'Jl. Pasien No. 1, Jakarta',
            'no_ktp' => '4567890123456789',
            'no_hp' => '081234567893',
            'no_rm' => 'RM000001',
        ]);

        // Pasien 2
        User::create([
            'nama' => 'Joko Pramono',
            'email' => 'joko@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'alamat' => 'Jl. Pasien No. 2, Jakarta',
            'no_ktp' => '5678901234567890',
            'no_hp' => '081234567894',
            'no_rm' => 'RM000002',
        ]);

        // Pasien 3
        User::create([
            'nama' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'alamat' => 'Jl. Pasien No. 3, Jakarta',
            'no_ktp' => '6789012345678901',
            'no_hp' => '081234567895',
            'no_rm' => 'RM000003',
        ]);
    }
}
