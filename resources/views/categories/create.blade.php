@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Tambah Kategori</h5>
</div>

<div class="card" style="max-width: 560px;">
    <div class="card-body p-4">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="category_name"
                    class="form-control @error('category_name') is-invalid @enderror"
                    value="{{ old('category_name') }}" required autofocus>
                @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Deskripsi opsional...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
