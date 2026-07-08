@extends('layouts.app')

@section('title', 'Supplier')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-truck me-2"></i>Data Supplier</h5>
    <a href="{{ route('suppliers.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Supplier
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto flex-grow-1">
                <input type="text" name="q" class="form-control" placeholder="Cari nama supplier..."
                    value="{{ request('q') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
                @if(request('q'))
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-danger">Reset</a>
                @endif
            </div>
        </form>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Supplier</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th class="text-center">Jml Barang</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($suppliers as $i => $supplier)
                <tr>
                    <td>{{ $suppliers->firstItem() + $i }}</td>
                    <td class="fw-semibold">{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->phone ?? '-' }}</td>
                    <td>{{ $supplier->email ?? '-' }}</td>
                    <td class="text-muted" style="max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $supplier->address ?? '-' }}
                    </td>
                    <td class="text-center">
                        <span class="badge bg-primary">{{ $supplier->items_count }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin hapus supplier \'{{ $supplier->supplier_name }}\'?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        Tidak ada data supplier.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>

@endsection
