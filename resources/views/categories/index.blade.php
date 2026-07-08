@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-tags me-2"></i>Data Kategori</h5>
    <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body">
        {{-- Search --}}
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto flex-grow-1">
                <input type="text" name="q" class="form-control" placeholder="Cari nama kategori..."
                    value="{{ request('q') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
                @if(request('q'))
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">Reset</a>
                @endif
            </div>
        </form>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Jml Barang</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $i => $category)
                <tr>
                    <td>{{ $categories->firstItem() + $i }}</td>
                    <td class="fw-semibold">{{ $category->category_name }}</td>
                    <td class="text-muted">{{ $category->description ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge bg-primary">{{ $category->items_count }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin hapus kategori \'{{ $category->category_name }}\'?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        Tidak ada data kategori.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end">
            {{ $categories->links() }}
        </div>
    </div>
</div>

@endsection
