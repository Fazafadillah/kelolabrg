<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
// use Maatwebsite\Excel\Validator\Failure;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ItemsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsEmptyRows,
    SkipsOnError,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading
{
    /**
     * Simpan baris yang gagal agar bisa ditampilkan ke user
     */
    public array $failures = [];
    public array $errors   = [];

    /**
     * Kolom yang diharapkan di Excel:
     * | Kode Barang | Nama Barang | Kategori | Supplier | Stok | Satuan | Harga (Rp) | Deskripsi |
     *
     * Kategori & Supplier diisi dengan NAMA (bukan ID),
     * import akan otomatis mencari ID-nya di database.
     * Kalau nama tidak ditemukan, kolom akan diset NULL.
     */
    public function model(array $row): ?Item
    {
        $kode = trim($row['kode_barang'] ?? $row['kode barang'] ?? '');
        $nama = trim($row['nama_barang'] ?? $row['nama barang'] ?? '');

        if (empty($kode) || empty($nama)) {
            return null;
        }

        // Cari category_id berdasarkan nama kategori
        $category = null;
        $namaKategori = trim($row['kategori'] ?? '');
        if (!empty($namaKategori)) {
            $category = Category::where('category_name', $namaKategori)->first();
        }

        // Cari supplier_id berdasarkan nama supplier
        $supplier = null;
        $namaSupplier = trim($row['supplier'] ?? '');
        if (!empty($namaSupplier)) {
            $supplier = Supplier::where('supplier_name', $namaSupplier)->first();
        }

        // Bersihkan angka harga: hapus titik ribuan, koma desimal, spasi
        $harga = preg_replace('/[^0-9.]/', '', str_replace(',', '.', $row['harga_rp'] ?? $row['harga (rp)'] ?? 0));

        return Item::updateOrCreate(
            ['item_code' => $kode],
            [
                'item_name'   => $nama,
                'category_id' => $category?->id,
                'supplier_id' => $supplier?->id,
                'stock'       => (int) ($row['stok'] ?? 0),
                'unit'        => $row['satuan'] ?? 'pcs',
                'price'       => (float) ($harga ?: 0),
                'description' => $row['deskripsi'] ?? null,
            ]
        );
    }

    /**
     * Proses 100 baris sekaligus (efisiensi memori)
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Baca file per 100 baris (tidak load semua ke memori sekaligus)
     */
    public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return [
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:150'],
            'stok'        => ['nullable', 'numeric', 'min:0'],
            'harga_rp'    => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'kode_barang.required' => 'Kolom "Kode Barang" wajib diisi di baris :attribute.',
            'nama_barang.required' => 'Kolom "Nama Barang" wajib diisi di baris :attribute.',
            'stok.min'             => 'Stok tidak boleh negatif di baris :attribute.',
        ];
    }

    /**
     * Tangkap baris yang gagal validasi
     */
    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row'    => $failure->row(),
                'errors' => $failure->errors(),
            ];
        }
    }

    /**
     * Tangkap error teknis (bukan validasi)
     */
    public function onError(Throwable $e): void
    {
        $this->errors[] = $e->getMessage();
    }
}
