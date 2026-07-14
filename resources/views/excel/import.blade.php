@extends('layouts.app')

@section('title', 'Import & Export Excel')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">
        <i class="bi bi-file-earmark-excel me-2 text-success"></i>Import & Export Excel
    </h5>
</div>

{{-- ======================================================= --}}
{{-- FLASH MESSAGES --}}
{{-- ======================================================= --}}
@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('import_errors'))
    <div class="alert alert-danger alert-dismissible fade show">
        <strong><i class="bi bi-x-circle me-1"></i>Detail Error Import:</strong>
        <ul class="mb-0 mt-2">
            @foreach(session('import_errors') as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ======================================================= --}}
{{-- SECTION EXPORT --}}
{{-- ======================================================= --}}
<div class="card mb-4">
    <div class="card-header py-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-download me-2 text-primary"></i>Export Data ke Excel
        </h6>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">
            Download data dari database menjadi file <code>.xlsx</code>.
            Pilih export per tabel atau sekaligus semua data dalam satu file (3 sheet).
        </p>

        <div class="row g-3">

            {{-- Export Semua --}}
            <div class="col-md-6 col-lg-3">
                <div class="border rounded-3 p-3 h-100 d-flex flex-column">
                    <div class="mb-2">
                        <span class="badge bg-dark mb-2">3 Sheet</span>
                        <h6 class="fw-bold">Semua Data</h6>
                        <p class="text-muted small">Barang, Kategori & Supplier dalam satu file Excel.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('excel.export.all') }}" class="btn btn-dark btn-sm w-100">
                            <i class="bi bi-download me-1"></i> Export Semua
                        </a>
                    </div>
                </div>
            </div>

            {{-- Export Barang --}}
            <div class="col-md-6 col-lg-3">
                <div class="border rounded-3 p-3 h-100 d-flex flex-column border-success">
                    <div class="mb-2">
                        <span class="badge bg-success mb-2">Items</span>
                        <h6 class="fw-bold">Data Barang</h6>
                        <p class="text-muted small">Semua data barang beserta kategori & supplier.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('excel.export.items') }}" class="btn btn-success btn-sm w-100">
                            <i class="bi bi-box-seam me-1"></i> Export Barang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Export Kategori --}}
            <div class="col-md-6 col-lg-3">
                <div class="border rounded-3 p-3 h-100 d-flex flex-column border-primary">
                    <div class="mb-2">
                        <span class="badge bg-primary mb-2">Categories</span>
                        <h6 class="fw-bold">Data Kategori</h6>
                        <p class="text-muted small">Semua kategori beserta jumlah barang tiap kategori.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('excel.export.categories') }}" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-tags me-1"></i> Export Kategori
                        </a>
                    </div>
                </div>
            </div>

            {{-- Export Supplier --}}
            <div class="col-md-6 col-lg-3">
                <div class="border rounded-3 p-3 h-100 d-flex flex-column border-purple" style="border-color:#8e44ad!important;">
                    <div class="mb-2">
                        <span class="badge mb-2" style="background:#8e44ad;">Suppliers</span>
                        <h6 class="fw-bold">Data Supplier</h6>
                        <p class="text-muted small">Semua data supplier beserta jumlah barang yang dipasok.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('excel.export.suppliers') }}" class="btn btn-sm w-100 text-white" style="background:#8e44ad;">
                            <i class="bi bi-truck me-1"></i> Export Supplier
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ======================================================= --}}
{{-- SECTION IMPORT --}}
{{-- ======================================================= --}}
<div class="row g-4">

    {{-- Import Barang --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header py-3 border-success" style="border-left: 4px solid #2d6a4f;">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-upload me-2 text-success"></i>Import Barang
                </h6>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="text-muted small">
                    Upload file Excel berisi data barang. Kolom yang dibutuhkan:
                </p>
                <div class="bg-light rounded p-2 mb-3 small font-monospace">
                    Kode Barang | Nama Barang | Kategori | Supplier | Stok | Satuan | Harga (Rp) | Deskripsi
                </div>
                <div class="alert alert-info py-2 small mb-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Kolom <strong>Kategori</strong> & <strong>Supplier</strong> diisi dengan
                    <strong>nama</strong> (bukan angka ID). Jika nama tidak ditemukan di database,
                    kolom tersebut akan dikosongkan.
                    <br>Jika <strong>Kode Barang</strong> sudah ada, data akan diperbarui (update).
                </div>
                <div class="mb-3">
                    <a href="{{ route('excel.template.items') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Download Template
                    </a>
                </div>
                <form action="{{ route('excel.import.items') }}" method="POST" enctype="multipart/form-data" class="mt-auto">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Pilih File (.xlsx / .xls / .csv)</label>
                        <input type="file" name="file" class="form-control form-control-sm @error('file') is-invalid @enderror"
                            accept=".xlsx,.xls,.csv" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success btn-sm w-100"
                        onclick="return confirm('Yakin ingin import data barang? Data yang sudah ada akan diperbarui.')">
                        <i class="bi bi-upload me-1"></i> Import Barang
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Import Kategori --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header py-3" style="border-left: 4px solid #4a69bd;">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-upload me-2 text-primary"></i>Import Kategori
                </h6>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="text-muted small">
                    Upload file Excel berisi data kategori. Kolom yang dibutuhkan:
                </p>
                <div class="bg-light rounded p-2 mb-3 small font-monospace">
                    Nama Kategori | Deskripsi
                </div>
                <div class="alert alert-info py-2 small mb-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Jika <strong>Nama Kategori</strong> sudah ada di database,
                    data akan diperbarui (update). Jika belum ada, akan ditambahkan baru.
                </div>
                <div class="mb-3">
                    <a href="{{ route('excel.template.categories') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Download Template
                    </a>
                </div>
                <form action="{{ route('excel.import.categories') }}" method="POST" enctype="multipart/form-data" class="mt-auto">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Pilih File (.xlsx / .xls / .csv)</label>
                        <input type="file" name="file" class="form-control form-control-sm @error('file') is-invalid @enderror"
                            accept=".xlsx,.xls,.csv" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100"
                        onclick="return confirm('Yakin ingin import data kategori?')">
                        <i class="bi bi-upload me-1"></i> Import Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Import Supplier --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header py-3" style="border-left: 4px solid #8e44ad;">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-upload me-2" style="color:#8e44ad;"></i>Import Supplier
                </h6>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="text-muted small">
                    Upload file Excel berisi data supplier. Kolom yang dibutuhkan:
                </p>
                <div class="bg-light rounded p-2 mb-3 small font-monospace">
                    Nama Supplier | Telepon | Email | Alamat
                </div>
                <div class="alert alert-info py-2 small mb-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Jika <strong>Nama Supplier</strong> sudah ada di database,
                    data akan diperbarui (update). Jika belum ada, akan ditambahkan baru.
                </div>
                <div class="mb-3">
                    <a href="{{ route('excel.template.suppliers') }}" class="btn btn-outline-secondary btn-sm" style="color:#8e44ad; border-color:#8e44ad;">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Download Template
                    </a>
                </div>
                <form action="{{ route('excel.import.suppliers') }}" method="POST" enctype="multipart/form-data" class="mt-auto">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Pilih File (.xlsx / .xls / .csv)</label>
                        <input type="file" name="file" class="form-control form-control-sm @error('file') is-invalid @enderror"
                            accept=".xlsx,.xls,.csv" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-sm w-100 text-white"
                        style="background:#8e44ad;"
                        onclick="return confirm('Yakin ingin import data supplier?')">
                        <i class="bi bi-upload me-1"></i> Import Supplier
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
