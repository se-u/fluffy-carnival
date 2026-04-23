<?php

namespace App\Exports;

use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JadwalPeriksaExport
{
    public function download()
    {
        $dokterId = Auth::id();

        $jadwals = JadwalPeriksa::where('id_dokter', $dokterId)
            ->with('dokter.poli')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Hari');
        $sheet->setCellValue('C1', 'Jam Mulai');
        $sheet->setCellValue('D1', 'Jam Selesai');
        $sheet->setCellValue('E1', 'No. Antrian Sekarang');
        $sheet->setCellValue('F1', 'Sisa Antrian');

        // Data
        $row = 2;
        foreach ($jadwals as $index => $jadwal) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $jadwal->hari);
            $sheet->setCellValue('C' . $row, $jadwal->jam_mulai);
            $sheet->setCellValue('D' . $row, $jadwal->jam_selesai);
            $sheet->setCellValue('E' . $row, $jadwal->no_antrian_sekarang);
            $sheet->setCellValue('F' . $row, $jadwal->getRemainingQueueCount());
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'jadwal_periksa_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
