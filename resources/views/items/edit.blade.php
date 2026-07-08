@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Edit Barang: {{ $item->item_name }}</h5>
</div>

<div class="card" style="max-width: 740px;">
    <div class="card-body p-4">
        <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('items._form', ['item' => $item])
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i> Update Barang
                </button>
                <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
