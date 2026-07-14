<?php

namespace App\Http\Controllers;

use App\Exports\AllDataExport;
use App\Exports\CategoriesExport;
use App\Exports\ItemsExport;
use App\Exports\SuppliersExport;
use App\Imports\CategoriesImport;
use App\Imports\ItemsImport;
use App\Imports\SuppliersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExcelController extends Controller
{
    // ============================================================
    // EXPORT
    // ============================================================

    /**
     * Export semua data (3 sheet: barang, kategori, supplier)
     */
    public function exportAll()
    {
        $filename = 'inventory-semua-data-' . Carbon::now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new AllDataExport(), $filename);
    }

    /**
     * Export data barang saja
     */
    public function exportItems()
    {
        $filename = 'inventory-barang-' . Carbon::now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new ItemsExport(), $filename);
    }

    /**
     * Export data kategori saja
     */
    public function exportCategories()
    {
        $filename = 'inventory-kategori-' . Carbon::now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new CategoriesExport(), $filename);
    }

    /**
     * Export data supplier saja
     */
    public function exportSuppliers()
    {
        $filename = 'inventory-supplier-' . Carbon::now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new SuppliersExport(), $filename);
    }

    // ============================================================
    // IMPORT — Tampilkan halaman form upload
    // ============================================================

    public function showImport()
    {
        return view('excel.import');
    }

    // ============================================================
    // IMPORT — Proses file yang diupload
    // ============================================================

    /**
     * Import data barang dari Excel
     */
    public function importItems(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ], [
            'file.required' => 'File wajib dipilih.',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv.',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $import = new ItemsImport();
        Excel::import($import, $request->file('file'));

        // Kumpulkan semua pesan error dari baris yang gagal
        $errorMessages = [];
        foreach ($import->failures as $failure) {
            $errorMessages[] = 'Baris ' . $failure['row'] . ': ' . implode(', ', $failure['errors']);
        }
        foreach ($import->errors as $err) {
            $errorMessages[] = $err;
        }

        if (!empty($errorMessages)) {
            return redirect()->route('excel.import')
                ->with('import_errors', $errorMessages)
                ->with('warning', 'Import selesai dengan beberapa peringatan. Cek detail di bawah.');
        }

        return redirect()->route('excel.import')
            ->with('success', 'Data barang berhasil diimport dari Excel.');
    }

    /**
     * Import data kategori dari Excel
     */
    public function importCategories(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ], [
            'file.required' => 'File wajib dipilih.',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv.',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            Excel::import(new CategoriesImport(), $request->file('file'));
            return redirect()->route('excel.import')
                ->with('success', 'Data kategori berhasil diimport dari Excel.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = [];
            foreach ($e->failures() as $failure) {
                $errors[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->route('excel.import')
                ->with('import_errors', $errors)
                ->with('error', 'Import gagal karena ada data yang tidak valid.');
        }
    }

    /**
     * Import data supplier dari Excel
     */
    public function importSuppliers(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ], [
            'file.required' => 'File wajib dipilih.',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv.',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            Excel::import(new SuppliersImport(), $request->file('file'));
            return redirect()->route('excel.import')
                ->with('success', 'Data supplier berhasil diimport dari Excel.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = [];
            foreach ($e->failures() as $failure) {
                $errors[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->route('excel.import')
                ->with('import_errors', $errors)
                ->with('error', 'Import gagal karena ada data yang tidak valid.');
        }
    }

    // ============================================================
    // DOWNLOAD TEMPLATE
    // Template kosong agar user tahu format kolom yang benar
    // ============================================================

    public function downloadTemplateItems()
    {
        $filename = 'template-import-barang.xlsx';
        return Excel::download(new \App\Exports\TemplateItemsExport(), $filename);
    }

    public function downloadTemplateCategories()
    {
        $filename = 'template-import-kategori.xlsx';
        return Excel::download(new \App\Exports\TemplateCategoriesExport(), $filename);
    }

    public function downloadTemplateSuppliers()
    {
        $filename = 'template-import-supplier.xlsx';
        return Excel::download(new \App\Exports\TemplateSuppliersExport(), $filename);
    }
}
