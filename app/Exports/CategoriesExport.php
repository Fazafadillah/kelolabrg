<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CategoriesExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function collection()
    {
        return Category::withCount('items')->orderBy('id')->get();
    }

    public function title(): string
    {
        return 'Data Kategori';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Deskripsi',
            'Jumlah Barang',
            'Tanggal Dibuat',
        ];
    }

    public function map($category): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $category->category_name,
            $category->description ?? '-',
            $category->items_count,
            \Carbon\Carbon::parse($category->created_at)->format('d/m/Y'),
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
            ],
        ];
    }
}
