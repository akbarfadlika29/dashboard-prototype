<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'nip' => $credentials['nip'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'kepala_seksi') {
                return redirect()->route('admin.approval.index');
            }

            return redirect()->route('dataset.index');
        }

        return back()->withErrors([
            'nip' => 'NIP atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
