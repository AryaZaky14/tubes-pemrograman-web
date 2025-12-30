<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {

            // ADMIN
            if (Auth::user()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            }

            // KASIR
            if (Auth::user()->role_id == 2) {
                return redirect()->route('kasir.index');
            }

            // fallback
            Auth::logout();
            return redirect('/login');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function loginProcess(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // ambil user berdasarkan username
        $user = DB::table('user')
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return back()->with('error', 'Username atau password salah!');
        }

        // cek password hash
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Username atau password salah!');
        }

        // login ke Laravel
        Auth::loginUsingId($user->id_user);
        $request->session()->regenerate();

        // redirect sesuai role
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role_id == 2) {
            return redirect()->route('kasir.index');
        }

        // jika role tidak valid
        Auth::logout();
        return redirect('/login')->with('error', 'Role tidak dikenali');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
