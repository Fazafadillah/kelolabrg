<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'supplier']);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->q . '%')
                  ->orWhere('item_code', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $items      = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('category_name')->get();

        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        $suppliers  = Supplier::orderBy('supplier_name')->get();

        return view('items.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_code'   => ['required', 'string', 'max:50', 'unique:items,item_code'],
            'item_name'   => ['required', 'string', 'max:150'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'stock'       => ['required', 'integer', 'min:0'],
            'unit'        => ['required', 'string', 'max:20'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'item_code.required' => 'Kode barang wajib diisi.',
            'item_code.unique'   => 'Kode barang sudah digunakan.',
            'item_name.required' => 'Nama barang wajib diisi.',
            'stock.required'     => 'Stok wajib diisi.',
            'stock.min'          => 'Stok tidak boleh negatif.',
            'price.required'     => 'Harga wajib diisi.',
            'price.min'          => 'Harga tidak boleh negatif.',
            'image.image'        => 'File harus berupa gambar.',
            'image.mimes'        => 'Format gambar: jpeg, jpg, png, webp.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->only('item_code', 'item_name', 'category_id', 'supplier_id', 'stock', 'unit', 'price', 'description');

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
            // Simpan hanya nama file bukan path lengkap
            $data['image'] = basename($data['image']);
        }

        Item::create($data);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('category_name')->get();
        $suppliers  = Supplier::orderBy('supplier_name')->get();

        return view('items.edit', compact('item', 'categories', 'suppliers'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item_code'   => ['required', 'string', 'max:50', 'unique:items,item_code,' . $item->id],
            'item_name'   => ['required', 'string', 'max:150'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'stock'       => ['required', 'integer', 'min:0'],
            'unit'        => ['required', 'string', 'max:20'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'item_code.required' => 'Kode barang wajib diisi.',
            'item_code.unique'   => 'Kode barang sudah digunakan.',
            'item_name.required' => 'Nama barang wajib diisi.',
            'stock.min'          => 'Stok tidak boleh negatif.',
            'price.min'          => 'Harga tidak boleh negatif.',
            'image.image'        => 'File harus berupa gambar.',
            'image.mimes'        => 'Format gambar: jpeg, jpg, png, webp.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->only('item_code', 'item_name', 'category_id', 'supplier_id', 'stock', 'unit', 'price', 'description');

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($item->image && Storage::disk('public')->exists('uploads/' . $item->image)) {
                Storage::disk('public')->delete('uploads/' . $item->image);
            }
            $data['image'] = basename($request->file('image')->store('uploads', 'public'));
        }

        $item->update($data);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        // Hapus gambar dari storage jika ada
        if ($item->image && Storage::disk('public')->exists('uploads/' . $item->image)) {
            Storage::disk('public')->delete('uploads/' . $item->image);
        }

        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
