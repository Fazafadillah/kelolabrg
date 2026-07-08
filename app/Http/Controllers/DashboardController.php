<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems      = Item::count();
        $totalStock      = Item::sum('stock');
        $totalCategories = Category::count();
        $totalSuppliers  = Supplier::count();

        // Barang dengan stok menipis (<= 10), ambil 5 teratas
        $lowStockItems = Item::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // 5 barang terbaru
        $latestItems = Item::with(['category'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalItems',
            'totalStock',
            'totalCategories',
            'totalSuppliers',
            'lowStockItems',
            'latestItems'
        ));
    }
}
