<?php

namespace App\Exports;

use App\Models\Obat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ObatExport
{
    public function download()
    {
        $obats = Obat::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Obat');
        $sheet->setCellValue('C1', 'Kemasan');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Stok');
        $sheet->setCellValue('F1', 'Status Stok');

        // Data
        $row = 2;
        foreach ($obats as $index => $obat) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $obat->nama_obat);
            $sheet->setCellValue('C' . $row, $obat->kemasan);
            $sheet->setCellValue('D' . $row, 'Rp ' . number_format($obat->harga, 0, ',', '.'));
            $sheet->setCellValue('E' . $row, $obat->stok);
            $sheet->setCellValue('F' . $row, $obat->isOutOfStock() ? 'Habis' : ($obat->isLowStock() ? 'Menipis' : 'Tersedia'));
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_obat_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
