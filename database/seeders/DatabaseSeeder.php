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
            PoliSeeder::class,        // 1. Poli (master data)
            UserSeeder::class,         // 2. Users (admin, dokter, pasien)
            ObatSeeder::class,         // 3. Obat (master data)
            JadwalPeriksaSeeder::class, // 4. Jadwal Periksa (depends on User)
        ]);
    }
}
