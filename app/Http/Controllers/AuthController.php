<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Jika email dan password cocok dengan database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            LogHelper::log('LOGIN', 'Authentication', "User logged into CMS: " . Auth::user()->email);
            return redirect()->intended('cms'); // Lempar ke Dashboard CMS
        }

        // Jika salah, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ])->onlyInput('email');
    }

    // Proses keluar sesi (Logout)
    public function logout(Request $request)
    {
        $userEmail = Auth::user()->email ?? 'Unknown';
        LogHelper::log('LOGOUT', 'Authentication', "User logged out from CMS: $userEmail");

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login'); // Kembali ke halaman login
    }
}