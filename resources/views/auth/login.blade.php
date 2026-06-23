@extends('layouts.auth')

@section('title', 'Login - PILMAPRES UM Metro')
@section('form-title', 'Welcome Back')
@section('form-subtitle', 'Please enter your credentials to continue')

@section('form-content')
    <form method="POST" action="{{ route('login') }}" data-turbo="false">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required autofocus autocomplete="username" inputmode="text" placeholder="Enter your username">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-2">
            <label class="form-label" for="password">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" placeholder="Enter your password">
                <span class="toggle-pw" id="togglePassword" role="button" tabindex="0" aria-label="Toggle password visibility">
                    <i class="fa-regular fa-eye"></i>
                </span>
            </div>
        </div>

        <div class="form-options">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" class="btn-login">
            <i class="fa-solid fa-right-to-bracket me-2"></i> Sign In
        </button>

        <div class="divider">Or continue with</div>

        <div class="social-btns">
            <a href="#" class="btn-social" onclick="event.preventDefault(); Swal.fire({icon:'info',title:'Coming Soon',text:'Google sign-in will be available soon.',confirmButtonColor:'#1a3c7a',customClass:{confirmButton:'btn btn-primary rounded-pill px-4'},buttonsStyling:false});">
                <i class="fa-brands fa-google me-1"></i> Google
            </a>
            <a href="#" class="btn-social" onclick="event.preventDefault(); Swal.fire({icon:'info',title:'Coming Soon',text:'Microsoft sign-in will be available soon.',confirmButtonColor:'#1a3c7a',customClass:{confirmButton:'btn btn-primary rounded-pill px-4'},buttonsStyling:false});">
                <i class="fa-brands fa-microsoft me-1"></i> Microsoft
            </a>
        </div>
    </form>

    <div class="register-link">
        Don't have an account? <a href="{{ route('register') }}">Register here</a>
    </div>

<script>
(function() {
    var toggle = document.getElementById('togglePassword');
    var pw = document.getElementById('password');
    if (toggle && pw) {
        function togglePassword() {
            var type = pw.getAttribute('type') === 'password' ? 'text' : 'password';
            pw.setAttribute('type', type);
            toggle.querySelector('i').className = type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
        }
        toggle.addEventListener('click', togglePassword);
        toggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePassword();
            }
        });
    }
})();
</script>
@endsection
