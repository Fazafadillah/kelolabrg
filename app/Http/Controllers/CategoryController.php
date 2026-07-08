<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * List semua kategori + pencarian
     */
    public function index(Request $request)
    {
        $query = Category::withCount('items');

        if ($request->filled('q')) {
            $query->where('category_name', 'like', '%' . $request->q . '%');
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('categories.index', compact('categories'));
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:100', 'unique:categories,category_name'],
            'description'   => ['nullable', 'string'],
        ], [
            'category_name.required' => 'Nama kategori wajib diisi.',
            'category_name.unique'   => 'Nama kategori sudah ada.',
            'category_name.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        Category::create($request->only('category_name', 'description'));

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit kategori
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:100', 'unique:categories,category_name,' . $category->id],
            'description'   => ['nullable', 'string'],
        ], [
            'category_name.required' => 'Nama kategori wajib diisi.',
            'category_name.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        $category->update($request->only('category_name', 'description'));

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('categories.index')
                ->with('success', 'Kategori berhasil dihapus.');
        } catch (QueryException $e) {
            // Error 23000 = foreign key constraint violation
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data barang.');
        }
    }
}
