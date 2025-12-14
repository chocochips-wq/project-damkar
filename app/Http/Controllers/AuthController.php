<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('beranda');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username_admin' => 'required',
            'password_admin' => 'required',
        ]);

        $admin = Admin::where('username_admin', $request->username_admin)
                     ->where('is_delete_admin', '0')
                     ->first();

        if ($admin && Hash::check($request->password_admin, $admin->password_admin)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('beranda');
        }

        return back()->withErrors(['error' => 'Username atau password salah']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:50',
            'username_admin' => 'required|string|max:20|unique:t_admin,username_admin',
            'password_admin' => 'required|string|min:6|confirmed',
        ]);

        $lastAdmin = Admin::orderBy('id_admin', 'desc')->first();
        $newId = 'ADM000';
        
        if ($lastAdmin) {
            $lastNumber = intval(substr($lastAdmin->id_admin, 3));
            $newId = 'ADM' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        Admin::create([
            'id_admin' => $newId,
            'nama_admin' => $request->nama_admin,
            'username_admin' => $request->username_admin,
            'password_admin' => Hash::make($request->password_admin),
            'is_delete_admin' => '0',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}