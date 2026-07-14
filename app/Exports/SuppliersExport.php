<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SuppliersExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function collection()
    {
        return Supplier::withCount('items')->orderBy('id')->get();
    }

    public function title(): string
    {
        return 'Data Supplier';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Supplier',
            'Telepon',
            'Email',
            'Alamat',
            'Jumlah Barang',
            'Tanggal Dibuat',
        ];
    }

    public function map($supplier): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $supplier->supplier_name,
            $supplier->phone    ?? '-',
            $supplier->email    ?? '-',
            $supplier->address  ?? '-',
            $supplier->items_count,
            \Carbon\Carbon::parse($supplier->created_at)->format('d/m/Y'),
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
            ],
        ];
    }
}
