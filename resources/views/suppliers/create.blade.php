{{-- resources/views/suppliers/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Tambah Supplier</h5>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            @include('suppliers._form', ['supplier' => null])
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
