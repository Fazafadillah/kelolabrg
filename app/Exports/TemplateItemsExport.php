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

class TemplateItemsExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function title(): string
    {
        return 'Template Barang';
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Supplier',
            'Stok',
            'Satuan',
            'Harga (Rp)',
            'Deskripsi',
        ];
    }

    /**
     * Isi contoh data agar user tahu cara mengisinya
     */
    public function array(): array
    {
        return [
            ['BRG-001', 'Laptop Asus Vivobook', 'Elektronik', 'PT Sumber Makmur', 10, 'unit', 7500000, 'Contoh deskripsi'],
            ['BRG-002', 'Pulpen Standard',       'Alat Tulis Kantor', 'CV Mitra Jaya', 50, 'pcs', 3500, ''],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2D6A4F'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        // Style baris contoh
        $exampleStyle = [
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD4EDDA'],
            ],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        return [
            1 => $headerStyle,
            2 => $exampleStyle,
            3 => $exampleStyle,
        ];
    }
}
