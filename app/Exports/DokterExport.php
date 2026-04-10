<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class DokterExport
{
    protected $query;

    public function __construct()
    {
        $this->query = User::where('role', 'dokter')
            ->leftJoin('poli', 'users.id_poli', '=', 'poli.id')
            ->select('users.id', 'users.nama', 'users.email', 'users.no_hp', 'poli.nama_poli as poli');
    }

    public function download()
    {
        $dokters = $this->query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'No. HP');
        $sheet->setCellValue('E1', 'Poli');

        // Data
        $row = 2;
        foreach ($dokters as $index => $dokter) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $dokter->nama);
            $sheet->setCellValue('C' . $row, $dokter->email);
            $sheet->setCellValue('D' . $row, $dokter->no_hp ?? '-');
            $sheet->setCellValue('E' . $row, $dokter->poli ?? '-');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_dokter_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
