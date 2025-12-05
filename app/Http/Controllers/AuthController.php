<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Jika ada intended URL, redirect kesana. Jika tidak, ke dashboard
            $intendedUrl = session('url.intended');
            if ($intendedUrl && $intendedUrl !== route('admin.login.form')) {
                return redirect()->intended($intendedUrl);
            }
            
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Email atau password salah!')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
