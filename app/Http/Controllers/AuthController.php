<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use \App\Traits\Notifiable;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $this->sendNotification(Auth::id(), 'Selamat datang kembali, ' . Auth::user()->nama_lengkap . '!', 'success');
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nim' => 'required|string|max:50|unique:mahasiswa',
            'program_studi' => 'required|string|max:255',
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
        ]);

        Auth::login($user);

        $this->sendNotification($user->id, 'Akun Anda berhasil didaftarkan. Silakan lengkapi pendaftaran PILMAPRES.', 'info');
        $this->notifyAllAdmins('Mahasiswa baru telah mendaftar: ' . $user->nama_lengkap, 'info');

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
