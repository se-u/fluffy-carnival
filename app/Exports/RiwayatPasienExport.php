<?php

namespace App\Exports;

use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RiwayatPasienExport
{
    public function download()
    {
        $dokterId = Auth::id();

        // Get all patients that this doctor has examined
        $periksas = Periksa::whereHas('daftarPoli.jadwalPeriksa', function ($query) use ($dokterId) {
            $query->where('id_dokter', $dokterId);
        })
        ->with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.poli', 'detailPeriksas.obat'])
        ->orderBy('tgl_periksa', 'desc')
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Nama Pasien');
        $sheet->setCellValue('D1', 'Poli');
        $sheet->setCellValue('E1', 'Keluhan');
        $sheet->setCellValue('F1', 'Catatan');
        $sheet->setCellValue('G1', 'Obat');
        $sheet->setCellValue('H1', 'Total Biaya');

        // Data
        $row = 2;
        foreach ($periksas as $index => $periksa) {
            $obatList = $periksa->detailPeriksas->map(function ($detail) {
                return $detail->obat->nama_obat ?? '';
            })->filter()->implode(', ');

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $periksa->tgl_periksa->format('Y-m-d'));
            $sheet->setCellValue('C' . $row, $periksa->daftarPoli->pasien->nama ?? '-');
            $sheet->setCellValue('D' . $row, $periksa->daftarPoli->jadwalPeriksa->poli->nama_poli ?? '-');
            $sheet->setCellValue('E' . $row, $periksa->daftarPoli->keluhan);
            $sheet->setCellValue('F' . $row, $periksa->catatan);
            $sheet->setCellValue('G' . $row, $obatList ?: '-');
            $sheet->setCellValue('H' . $row, 'Rp ' . number_format($periksa->total_biaya, 0, ',', '.'));
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'riwayat_pasien_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
