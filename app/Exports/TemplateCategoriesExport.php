<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TemplateCategoriesExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function title(): string
    {
        return 'Template Kategori';
    }

    public function headings(): array
    {
        return [
            'Nama Kategori',
            'Deskripsi',
        ];
    }

    public function array(): array
    {
        return [
            ['Elektronik',        'Barang-barang elektronik'],
            ['Alat Tulis Kantor', 'Perlengkapan ATK'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4A69BD'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            2 => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD4E6FF']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            3 => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD4E6FF']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
        ];
    }
}
