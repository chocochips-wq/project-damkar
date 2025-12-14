<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('pengaturan.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'nama_admin' => 'required|string|max:50',
            'username_admin' => 'required|string|max:20|unique:t_admin,username_admin,' . $admin->id_admin . ',id_admin',
            'password_admin' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->nama_admin = $request->nama_admin;
        $admin->username_admin = $request->username_admin;

        if ($request->filled('password_admin')) {
            $admin->password_admin = Hash::make($request->password_admin);
        }

        $admin->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}