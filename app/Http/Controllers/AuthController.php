<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Sudah login: langsung arahkan sesuai role
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => $data['password'], 
            'role' => 'pasien',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Kamu sudah keluar.');
    }

    private function redirectByRole(): RedirectResponse
    {
        return Auth::user()->role === 'admin'
            ? redirect('/admin')
            : redirect()->route('pasien.dashboard');
    }
}