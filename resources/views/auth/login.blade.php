@extends('layouts.guest')

@section('content')
<div class="login-card card">
    <div class="card-body">
        <div class="text-center mb-4">
            <i class="bi bi-boxes fs-1 text-success"></i>
            <div class="login-brand mt-2">Inventory App</div>
            <p class="text-muted small">Sistem Pengelolaan Barang</p>
        </div>

        {{-- Error dari session --}}
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Error validasi --}}
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div><i class="bi bi-dot"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        required placeholder="Masukkan password">
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>

        <p class="text-center text-muted small mt-3 mb-0">
            Default: <strong>admin</strong> / <strong>admin123</strong>
        </p>
    </div>
</div>
@endsection
