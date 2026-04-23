<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            ['nama_obat' => 'Paracetamol 500mg', 'kemasan' => 'Strip', 'harga' => 5000],
            ['nama_obat' => 'Amoxicillin 500mg', 'kemasan' => 'Strip', 'harga' => 15000],
            ['nama_obat' => 'Ibuprofen 400mg', 'kemasan' => 'Strip', 'harga' => 8000],
            ['nama_obat' => 'Omeprazole 20mg', 'kemasan' => 'Strip', 'harga' => 12000],
            ['nama_obat' => 'Metformin 500mg', 'kemasan' => 'Strip', 'harga' => 10000],
            ['nama_obat' => 'Captopril 25mg', 'kemasan' => 'Strip', 'harga' => 8000],
            ['nama_obat' => 'Cefotaxime 1g', 'kemasan' => 'Vial', 'harga' => 25000],
            ['nama_obat' => 'Dexamethasone 0.5mg', 'kemasan' => 'Strip', 'harga' => 3000],
            ['nama_obat' => 'Antasida', 'kemasan' => 'Botol', 'harga' => 15000],
            ['nama_obat' => 'Vitamin B Complex', 'kemasan' => 'Strip', 'harga' => 7000],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
