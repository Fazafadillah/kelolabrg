<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ItemsExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    /**
     * Ambil semua data barang beserta relasi kategori & supplier
     */
    public function collection()
    {
        return Item::with(['category', 'supplier'])
            ->orderBy('id')
            ->get();
    }

    /**
     * Nama sheet di file Excel
     */
    public function title(): string
    {
        return 'Data Barang';
    }

    /**
     * Baris header kolom
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Supplier',
            'Stok',
            'Satuan',
            'Harga (Rp)',
            'Deskripsi',
            'Tanggal Ditambahkan',
        ];
    }

    /**
     * Mapping setiap baris data ke kolom Excel
     */
    public function map($item): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $item->item_code,
            $item->item_name,
            $item->category->category_name ?? '-',
            $item->supplier->supplier_name ?? '-',
            $item->stock,
            $item->unit,
            $item->price,   // angka murni agar bisa diolah di Excel
            $item->description ?? '-',
            $item->created_at->format('d/m/Y'),
        ];
    }

    /**
     * Styling header: background hijau, teks putih, tebal, rata tengah
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2D6A4F'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
