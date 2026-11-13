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
        ],
        [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Email tidak terdaftar -> error di kolom email
        if (! User::where('email', $credentials['email'])->exists()) {
            return back()
                ->withErrors(['email' => 'Email salah.'])
                ->onlyInput('email');
        }

        // Email ada, password salah -> error di kolom password
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['password' => 'Kata sandi salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        toast('Berhasil masuk! Mari lanjutkan langkah kecil untuk kesehatan mentalmu hari ini.', 'success');

        // JANGAN forget url.intended di sini — biar pasien kembali ke halaman sebelumnya.
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

        toast('Pendaftaran berhasil! Langkah awal yang baik untuk perjalanan kesehatan mentalmu.', 'success');

        return $this->redirectByRole();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast('Sesi diakhiri. Sampai jumpa lagi, semoga harimu menyenangkan!', 'info');

        return redirect()->route('home')->with('success', 'Kamu sudah keluar.');
    }

    private function redirectByRole(): RedirectResponse
    {
        $user = Auth::user();

        // Admin & psikolog selalu ke panel masing-masing, abaikan intended.
        $panel = match ($user->role) {
            'admin'    => '/admin',
            'psikolog' => '/panel-psikolog',
            default    => null,
        };

        if ($panel) {
            session()->forget('url.intended');
            return redirect($panel);
        }

        // Pasien: hormati intended, tapi jangan biarkan ke area panel mana pun.
        $intended = session()->get('url.intended');
        $path = $intended ? parse_url($intended, PHP_URL_PATH) : null;

        if ($path
            && ! str_starts_with($path, '/admin')
            && ! str_starts_with($path, '/panel-psikolog')) {
            return redirect()->intended(route('home'));
        }

        session()->forget('url.intended');

        return redirect()->route('home');
    }
}