<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->has('admin_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        // Simpan data admin ke session
        session([
            'admin_id'        => $user->id,
            'admin_username'  => $user->username,
            'admin_full_name' => $user->full_name,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang, ' . $user->full_name . '!');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_username', 'admin_full_name']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}
