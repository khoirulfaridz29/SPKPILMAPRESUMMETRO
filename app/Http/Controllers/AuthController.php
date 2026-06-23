<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use \App\Traits\Notifiable;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $throttleKey = 'login:' . strtolower($request->username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'username' => 'Too many login attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.',
            ]);
        }

        if (Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            $this->sendNotification(Auth::id(), 'Welcome back, ' . Auth::user()->nama_lengkap . '!', 'success');
            return redirect()->route('dashboard');
        }

        RateLimiter::hit($throttleKey, 180);

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    public function showRegister()
    {
        $jenjang = Jenjang::orderBy('id')->get();
        return view('auth.register', compact('jenjang'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'nim' => 'required|string|max:50|unique:mahasiswa',
            'program_studi' => 'required|string|max:255',
            'jenjang_id' => 'required|exists:jenjang,id',
        ]);

        // Buat Akun User
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        // Buat Profil Mahasiswa
        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'program_studi' => $request->program_studi,
            'jenjang_id' => $request->jenjang_id,
        ]);

        Auth::login($user);

        $this->sendNotification($user->id, 'Akun Anda berhasil didaftarkan. Silakan lengkapi pendaftaran PILMAPRES.', 'info');
        $this->notifyAllAdmins('Mahasiswa baru telah mendaftar: ' . $user->nama_lengkap, 'info');

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['username' => 'required|string']);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username not found.'])->onlyInput('username');
        }

        $this->notifyAllAdmins(
            'Password reset request from: ' . $user->nama_lengkap . ' (username: ' . $user->username . ')',
            'warning'
        );

        return back()->with('success', 'Password reset request has been sent to the admin. Please contact the admin to reset your password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
