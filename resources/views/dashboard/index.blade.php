@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg,#4a69bd,#6c8ce4)">
                <div>
                    <div class="stat-label">Total Barang</div>
                    <div class="stat-value">{{ $totalItems }}</div>
                </div>
                <i class="bi bi-box-seam stat-icon"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg,#2d6a4f,#52b788)">
                <div>
                    <div class="stat-label">Total Stok</div>
                    <div class="stat-value">{{ number_format($totalStock) }}</div>
                </div>
                <i class="bi bi-stack stat-icon"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg,#e67e22,#f0a500)">
                <div>
                    <div class="stat-label">Kategori</div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                </div>
                <i class="bi bi-tags stat-icon"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg,#8e44ad,#bb6bd9)">
                <div>
                    <div class="stat-label">Supplier</div>
                    <div class="stat-value">{{ $totalSuppliers }}</div>
                </div>
                <i class="bi bi-truck stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- STOK MENIPIS --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center gap-2 py-3">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    <span>Stok Menipis (≤ 10)</span>
                </div>
                <div class="card-body p-0">
                    @if ($lowStockItems->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockItems as $item)
                                    <tr>
                                        <td>{{ $item->item_name }}</td>
                                        <td class="text-center">
                                            <span class="badge stock-low">
                                                {{ $item->stock }} {{ $item->unit }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-check-circle fs-3 text-success"></i>
                            <p class="mt-2 mb-0">Semua stok aman <i class="bi bi-hand-thumbs-up-fill"></i></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- BARANG TERBARU --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center gap-2 py-3">
                    <i class="bi bi-clock-history text-primary"></i>
                    <span>Barang Terbaru</span>
                </div>
                <div class="card-body p-0">
                    @if ($latestItems->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestItems as $item)
                                    <tr>
                                        <td><code>{{ $item->item_code }}</code></td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->category->category_name ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $item->isLowStock() ? 'stock-low' : 'stock-ok' }}">
                                                {{ $item->stock }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3"></i>
                            <p class="mt-2 mb-0">Belum ada data barang.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
