@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Data Barang</h5>
    <a href="{{ route('items.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Barang
    </a>
</div>

<div class="card">
    <div class="card-body">
        {{-- Filter & Search --}}
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input type="text" name="q" class="form-control" placeholder="Cari kode / nama barang..."
                    value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                @if(request()->hasAny(['q', 'category']))
                    <a href="{{ route('items.index') }}" class="btn btn-outline-danger">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th class="text-center">Stok</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" class="item-thumb" alt="{{ $item->item_name }}">
                            @else
                                <div class="item-thumb-placeholder">📦</div>
                            @endif
                        </td>
                        <td><code>{{ $item->item_code }}</code></td>
                        <td class="fw-semibold">{{ $item->item_name }}</td>
                        <td>
                            @if($item->category)
                                <span class="badge bg-info text-dark">{{ $item->category->category_name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $item->supplier->supplier_name ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->isLowStock() ? 'stock-low' : 'stock-ok' }}">
                                {{ $item->stock }} {{ $item->unit }}
                            </span>
                        </td>
                        <td>{{ $item->formatted_price }}</td>
                        <td class="text-center">
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus barang \'{{ $item->item_name }}\'?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            Tidak ada data barang ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            {{ $items->links() }}
        </div>
    </div>
</div>

@endsection
