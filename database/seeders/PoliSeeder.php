<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            ['nama_poli' => 'Poli Umum', 'keterangan' => 'Pelayanan kesehatan umum'],
            ['nama_poli' => 'Poli Anak', 'keterangan' => 'Pelayanan kesehatan anak'],
            ['nama_poli' => 'Poli Kandungan', 'keterangan' => 'Pelayanan kesehatan ibu dan kandungan'],
            ['nama_poli' => 'Poli Penyakit Dalam', 'keterangan' => 'Pelayanan penyakit dalam'],
            ['nama_poli' => 'Poli Gigi', 'keterangan' => 'Pelayanan kesehatan gigi dan mulut'],
        ];

        foreach ($polis as $poli) {
            Poli::create($poli);
        }
    }
}
