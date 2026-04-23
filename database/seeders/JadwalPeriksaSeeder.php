<?php

namespace Database\Seeders;

use App\Models\JadwalPeriksa;
use App\Models\User;
use Illuminate\Database\Seeder;

class JadwalPeriksaSeeder extends Seeder
{
    public function run(): void
    {
        // Get dokter users
        $drBudi = User::where('email', 'drbudi@gmail.com')->first();
        $drSiti = User::where('email', 'drgsiti@gmail.com')->first();

        // Jadwal untuk dr. Budi (Poli Umum)
        $jadwals = [
            [
                'id_dokter' => $drBudi->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '12:00',
            ],
            [
                'id_dokter' => $drBudi->id,
                'hari' => 'Rabu',
                'jam_mulai' => '08:00',
                'jam_selesai' => '12:00',
            ],
            [
                'id_dokter' => $drBudi->id,
                'hari' => 'Jumat',
                'jam_mulai' => '13:00',
                'jam_selesai' => '17:00',
            ],
            // Jadwal untuk dr. Siti (Poli Anak)
            [
                'id_dokter' => $drSiti->id,
                'hari' => 'Selasa',
                'jam_mulai' => '08:00',
                'jam_selesai' => '14:00',
            ],
            [
                'id_dokter' => $drSiti->id,
                'hari' => 'Kamis',
                'jam_mulai' => '08:00',
                'jam_selesai' => '14:00',
            ],
        ];

        foreach ($jadwals as $jadwal) {
            JadwalPeriksa::create($jadwal);
        }
    }
}
