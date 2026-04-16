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
        $users = User::with('seksi')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $seksi = Seksi::all();
        return view('admin.user.create', compact('seksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|unique:users,nip',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $user->seksi()->sync($request->seksi_id ?? []);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $seksi = Seksi::all();
        return view('admin.user.edit', compact('user', 'seksi'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|unique:users,nip,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $data = [
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->seksi()->sync($request->seksi_id ?? []);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        return back()->with('success', 'User berhasil dihapus');
    }
}