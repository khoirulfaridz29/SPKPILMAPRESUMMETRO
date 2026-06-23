<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role', 'juri');
        $users = User::where('role', $role)->latest()->get();
        return view('admin.users.index', compact('users', 'role'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users',
            'password'     => ['required', Password::min(8)->letters()->numbers()],
            'role'         => 'required|in:juri,wr3,admin',
            'nidn'         => 'nullable|string|max:30',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'nidn'         => $request->nidn,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
        ]);

        return redirect()->route('admin.users.index', ['role' => $request->role])
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username,'.$user->id,
            'role'         => 'required|in:juri,wr3,admin',
            'nidn'         => 'nullable|string|max:30',
        ]);

        $data = $request->only(['nama_lengkap', 'username', 'role', 'nidn']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $role = $user->role;
        $user->delete();
        return redirect()->route('admin.users.index', ['role' => $role])
            ->with('success', 'Akun berhasil dihapus.');
    }

    public function resetPassword(User $user)
    {
        $mhs = $user->mahasiswa;
        if (!$mhs || !$mhs->nim) {
            return back()->with('error', 'Mahasiswa ini tidak memiliki NPM.');
        }

        $user->update(['password' => $mhs->nim]);
        return back()->with('success', 'Password akun ' . $user->nama_lengkap . ' telah direset ke NPM (' . $mhs->nim . ').');
    }
}
