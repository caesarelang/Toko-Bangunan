<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
{
    return view('auth.login');
}

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            $role = auth()->user()->role;

            return match ($role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'customer' => redirect()->intended('/customer/dashboard'),
                'owner' => redirect()->intended('/owner/dashboard'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showRegisterForm()
    {
        return view('auth.regis');
    }
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'whatsapp' => 'required|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'password' => 'required|string|min:8|confirmed',
        ], [
            // Custom error messages in Bahasa Indonesia
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'whatsapp.max' => 'Nomor WhatsApp maksimal 20 karakter',
            
            'latitude.required' => 'Lokasi belum dipilih, silakan pilih lokasi pada peta',
            'latitude.numeric' => 'Koordinat latitude tidak valid',
            'latitude.between' => 'Koordinat latitude harus antara -90 dan 90',
            
            'longitude.required' => 'Lokasi belum dipilih, silakan pilih lokasi pada peta',
            'longitude.numeric' => 'Koordinat longitude tidak valid',
            'longitude.between' => 'Koordinat longitude harus antara -180 dan 180',
            
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        // Redirect dengan pesan sukses
        return redirect()->intended('/')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
