@extends('layouts.auth')

@section('title', 'Forgot Password - PILMAPRES UM Metro')
@section('form-title', 'Forgot Password')
@section('form-subtitle', 'Enter your username and we will notify the admin')

@section('form-content')
    <form method="POST" action="{{ route('password.request') }}" data-turbo="false">
        @csrf

        <div class="mb-4">
            <label class="form-label" for="username">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Enter your username">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="fa-solid fa-paper-plane me-2"></i> Send Request
        </button>
    </form>

    <div class="register-link">
        <a href="{{ route('login') }}"><i class="fa-solid fa-arrow-left me-1"></i> Back to Login</a>
    </div>
@endsection
