{{-- resources/views/items/_form.blade.php --}}

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
        <input type="text" name="item_code"
            class="form-control @error('item_code') is-invalid @enderror"
            value="{{ old('item_code', $item->item_code ?? '') }}" required placeholder="BRG-001">
        @error('item_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
        <input type="text" name="item_name"
            class="form-control @error('item_name') is-invalid @enderror"
            value="{{ old('item_name', $item->item_name ?? '') }}" required>
        @error('item_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ old('category_id', $item->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->category_name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Supplier</label>
        <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
            <option value="">-- Pilih Supplier --</option>
            @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}"
                    {{ old('supplier_id', $item->supplier_id ?? '') == $sup->id ? 'selected' : '' }}>
                    {{ $sup->supplier_name }}
                </option>
            @endforeach
        </select>
        @error('supplier_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
        <input type="number" name="stock" min="0"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock', $item->stock ?? 0) }}" required>
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
        <input type="text" name="unit"
            class="form-control @error('unit') is-invalid @enderror"
            value="{{ old('unit', $item->unit ?? 'pcs') }}" placeholder="pcs / unit / box" required>
        @error('unit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
        <input type="number" name="price" min="0" step="0.01"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price', $item->price ?? 0) }}" required>
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Deskripsi</label>
    <textarea name="description" rows="3"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Deskripsi barang (opsional)...">{{ old('description', $item->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Gambar Barang</label>

    {{-- Preview gambar lama saat edit --}}
    @if(isset($item) && $item->image && $item->image_url)
        <div class="mb-2">
            <img src="{{ $item->image_url }}" alt="Gambar saat ini"
                style="width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;">
            <div class="text-muted small mt-1">Gambar saat ini. Upload baru untuk mengganti.</div>
        </div>
    @endif

    <input type="file" name="image" accept="image/jpeg,image/jpg,image/png,image/webp"
        class="form-control @error('image') is-invalid @enderror"
        id="imageInput">
    <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 2MB.</div>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    {{-- Preview gambar baru yang dipilih --}}
    <div id="imagePreviewWrap" class="mt-2 d-none">
        <img id="imagePreview" src="#" alt="Preview"
            style="width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;">
    </div>
</div>

@push('scripts')
<script>
    // Preview gambar sebelum upload
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const wrap = document.getElementById('imagePreviewWrap');
        const preview = document.getElementById('imagePreview');
        const reader = new FileReader();
        reader.onload = (ev) => {
            preview.src = ev.target.result;
            wrap.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
