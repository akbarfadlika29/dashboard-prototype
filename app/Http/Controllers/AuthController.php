<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use App\Models\LoginOtp;
use App\Models\LoginLog;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip' => ['required'],
            'password' => ['required'],
        ], [
            'nip.required' => 'NIP wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $key = 'login:' . $request->ip();

        // 🚫 RATE LIMIT
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'nip' => 'Terlalu banyak percobaan login. Coba lagi nanti.'
            ]);
        }

        // ❌ LOGIN GAGAL
        if (!Auth::attempt($request->only('nip', 'password'), $request->remember)) {

            RateLimiter::hit($key, 60);

            LoginLog::create([
                'nip' => $request->nip,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_success' => false
            ]);

            return back()->withErrors([
                'nip' => 'NIP atau password salah'
            ]);
        }

        // ✅ LOGIN BERHASIL (sementara)
        RateLimiter::clear($key);

        $user = Auth::user();

        // 🔐 GENERATE OTP
        $otp = rand(100000, 999999);

        // ❗ HAPUS OTP LAMA
        LoginOtp::where('user_id', $user->id)->delete();

        // ✅ SIMPAN OTP BARU
        LoginOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expired_at' => now()->addMinutes(5)
        ]);

        // 📲 KIRIM OTP VIA WHATSAPP (FONNTE)
        if ($user->no_hp) {

            Http::withHeaders([
                'Authorization' => config('services.fonnte.api_key')
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $user->no_hp,
                'message' => "🔐 Kode OTP Login Pusdatin:\n\n$otp\n\nBerlaku 5 menit. Jangan berikan ke siapapun."
            ]);

        } else {
            \Log::warning("User {$user->nip} tidak punya nomor HP");
        }

        // ❗ SIMPAN NIP KE SESSION (PENTING)
        session(['otp_nip' => $user->nip]);

        // ❗ LOGOUT dulu (belum final login)
        Auth::logout();

        return redirect()->route('otp.form');
    }

    public function showOtp()
    {
        // ❗ JAGA AGAR TIDAK BISA AKSES TANPA LOGIN STEP 1
        if (!session('otp_nip')) {
            return redirect()->route('login');
        }

        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ], [
            'otp.required' => 'OTP wajib diisi',
        ]);

        // ❗ AMBIL NIP DARI SESSION (AMAN)
        $nip = session('otp_nip');

        if (!$nip) {
            return redirect()->route('login');
        }

        $user = User::where('nip', $nip)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        // ✅ AMBIL OTP TERBARU
        $otp = LoginOtp::where('user_id', $user->id)
            ->latest()
            ->first();

        if (!$otp) {
            return back()->withErrors([
                'otp' => 'OTP tidak ditemukan'
            ]);
        }

        // ❌ OTP SALAH
        if ($otp->otp != $request->otp) {
            return back()->withErrors([
                'otp' => 'Kode OTP salah'
            ]);
        }

        // ❌ OTP EXPIRED
        if (now()->gt($otp->expired_at)) {
            return back()->withErrors([
                'otp' => 'OTP sudah kadaluarsa'
            ]);
        }

        // ✅ LOGIN FINAL
        Auth::login($user);

        // 📝 LOG LOGIN SUCCESS
        LoginLog::create([
            'user_id' => $user->id,
            'nip' => $user->nip,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_success' => true
        ]);

        // ❗ HAPUS OTP BIAR TIDAK BISA DIPAKAI ULANG
        $otp->delete();

        // ❗ HAPUS SESSION OTP
        session()->forget('otp_nip');

        return redirect()
            ->route('dataset.index')
            ->with('login_success', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}