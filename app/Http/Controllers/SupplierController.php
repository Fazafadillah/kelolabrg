<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::withCount('items');

        if ($request->filled('q')) {
            $query->where('supplier_name', 'like', '%' . $request->q . '%');
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => ['required', 'string', 'max:150'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'email'         => ['nullable', 'email', 'max:100'],
            'address'       => ['nullable', 'string'],
        ], [
            'supplier_name.required' => 'Nama supplier wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
        ]);

        Supplier::create($request->only('supplier_name', 'phone', 'email', 'address'));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'supplier_name' => ['required', 'string', 'max:150'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'email'         => ['nullable', 'email', 'max:100'],
            'address'       => ['nullable', 'string'],
        ], [
            'supplier_name.required' => 'Nama supplier wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
        ]);

        $supplier->update($request->only('supplier_name', 'phone', 'email', 'address'));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('suppliers.index')
                ->with('success', 'Supplier berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('suppliers.index')
                ->with('error', 'Supplier tidak dapat dihapus karena masih digunakan oleh data barang.');
        }
    }
}
