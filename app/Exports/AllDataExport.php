<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllDataExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * Satu file Excel dengan 3 sheet sekaligus:
     * Sheet 1 → Data Barang
     * Sheet 2 → Data Kategori
     * Sheet 3 → Data Supplier
     */
    public function sheets(): array
    {
        return [
            new ItemsExport(),
            new CategoriesExport(),
            new SuppliersExport(),
        ];
    }
}
