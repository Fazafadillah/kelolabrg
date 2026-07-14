<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SuppliersImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsEmptyRows
{
    /**
     * Kolom yang diharapkan di Excel:
     * | Nama Supplier | Telepon | Email | Alamat |
     */
    public function model(array $row): ?Supplier
    {
        $nama = trim($row['nama_supplier'] ?? $row['nama supplier'] ?? '');

        if (empty($nama)) {
            return null;
        }

        return Supplier::updateOrCreate(
            ['supplier_name' => $nama],
            [
                'phone'   => $row['telepon']  ?? null,
                'email'   => $row['email']    ?? null,
                'address' => $row['alamat']   ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nama_supplier' => ['required', 'string', 'max:150'],
            'email'         => ['nullable', 'email'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama_supplier.required' => 'Kolom "Nama Supplier" wajib diisi di baris :attribute.',
            'email.email'            => 'Format email tidak valid di baris :attribute.',
        ];
    }
}
