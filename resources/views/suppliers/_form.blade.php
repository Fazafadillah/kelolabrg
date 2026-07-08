{{-- resources/views/suppliers/_form.blade.php --}}

<div class="mb-3">
    <label class="form-label fw-semibold">Nama Supplier <span class="text-danger">*</span></label>
    <input type="text" name="supplier_name"
        class="form-control @error('supplier_name') is-invalid @enderror"
        value="{{ old('supplier_name', $supplier->supplier_name ?? '') }}" required autofocus>
    @error('supplier_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">No. Telepon</label>
        <input type="text" name="phone"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $supplier->phone ?? '') }}" placeholder="08xxx">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $supplier->email ?? '') }}" placeholder="email@domain.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Alamat</label>
    <textarea name="address" rows="3"
        class="form-control @error('address') is-invalid @enderror"
        placeholder="Alamat lengkap supplier...">{{ old('address', $supplier->address ?? '') }}</textarea>
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
