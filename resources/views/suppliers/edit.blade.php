@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Edit Supplier</h5>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf @method('PUT')
            @include('suppliers._form', ['supplier' => $supplier])
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i> Update
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
