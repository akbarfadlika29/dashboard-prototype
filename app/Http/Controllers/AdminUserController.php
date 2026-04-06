<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $user = User::with('seksi')->get();
        return view('admin.user.index', compact('user'));
    }

    public function create()
    {
        $seksi = Seksi::all();
        return view('admin.user.create', compact('seksi'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $user->seksi()->sync($request->seksi_id ?? []);

        return redirect()->route('admin.user.index');
    }
}