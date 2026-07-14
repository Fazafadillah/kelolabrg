<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithUpserts;

class CategoriesImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsEmptyRows
{
    /**
     * WithHeadingRow → baris pertama Excel dianggap header,
     * key array otomatis pakai nama kolom (snake_case dari header)
     *
     * Kolom yang diharapkan di Excel:
     * | Nama Kategori | Deskripsi |
     */
    public function model(array $row): ?Category
    {
        $nama = trim($row['nama_kategori'] ?? $row['nama kategori'] ?? '');

        if (empty($nama)) {
            return null; // skip baris kosong
        }

        // updateOrCreate: kalau nama sudah ada → update, kalau belum → insert baru
        return Category::updateOrCreate(
            ['category_name' => $nama],
            ['description'   => $row['deskripsi'] ?? null]
        );
    }

    /**
     * Validasi setiap baris sebelum diproses
     */
    public function rules(): array
    {
        return [
            'nama_kategori' => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * Pesan error validasi dalam bahasa Indonesia
     */
    public function customValidationMessages(): array
    {
        return [
            'nama_kategori.required' => 'Kolom "Nama Kategori" wajib diisi di baris :attribute.',
        ];
    }
}
