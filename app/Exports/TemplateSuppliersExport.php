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

class TemplateSuppliersExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function title(): string
    {
        return 'Template Supplier';
    }

    public function headings(): array
    {
        return [
            'Nama Supplier',
            'Telepon',
            'Email',
            'Alamat',
        ];
    }

    public function array(): array
    {
        return [
            ['PT Sumber Makmur', '081234567890', 'sumber@email.com', 'Jl. Industri No.10, Bandung'],
            ['CV Mitra Jaya',    '082198765432', 'mitra@email.com',  'Jl. Raya Timur No.5, Jakarta'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF8E44AD'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            2 => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF3D4FF']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            3 => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF3D4FF']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ],
        ];
    }
}
