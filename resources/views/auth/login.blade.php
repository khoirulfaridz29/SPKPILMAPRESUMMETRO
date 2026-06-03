@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/logoummetro.webp') }}" alt="Logo UM Metro" height="85" class="mb-3">
                    <h4 class="fw-bold">Login Sistem PILMAPRES</h4>
                    <p class="text-muted">Masukkan username dan password Anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0">Mahasiswa belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
