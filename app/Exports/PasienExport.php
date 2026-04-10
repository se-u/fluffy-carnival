<?php

namespace App\Exports;

use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PasienExport
{
    public function download()
    {
        $pasiens = User::where('role', 'pasien')
            ->select('id', 'nama', 'email', 'no_ktp', 'no_hp', 'alamat', 'no_rm')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'No. KTP');
        $sheet->setCellValue('E1', 'No. HP');
        $sheet->setCellValue('F1', 'Alamat');
        $sheet->setCellValue('G1', 'No. RM');

        // Data
        $row = 2;
        foreach ($pasiens as $index => $pasien) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $pasien->nama);
            $sheet->setCellValue('C' . $row, $pasien->email);
            $sheet->setCellValue('D' . $row, $pasien->no_ktp ?? '-');
            $sheet->setCellValue('E' . $row, $pasien->no_hp ?? '-');
            $sheet->setCellValue('F' . $row, $pasien->alamat ?? '-');
            $sheet->setCellValue('G' . $row, $pasien->no_rm ?? '-');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_pasien_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
