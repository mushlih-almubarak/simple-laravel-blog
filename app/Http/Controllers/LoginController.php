<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function loginUser(int $id)
    {
        // logout
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        // Login
        Auth::loginUsingId($id);
        request()->session()->regenerate();
        return redirect('/dashboard');
    }

    public function auth()
    {
        // validasi
        request()->validate([
            'emailOrUsername' => ['required'],
            'password' => ['required']
        ]);
        $remember = (request()->remember) ? true : false;
        // Jika login menggunakan email
        if (Auth::attempt(['email' => request()->emailOrUsername, 'password' => request()->password], $remember)) {
            // Buat lagi session baru
            request()->session()->regenerate();
            // Masukkan ke dashboard
            return redirect()->intended('/dashboard');
        }
        // Jika login menggunakan username
        else if (Auth::attempt(['username' => request()->emailOrUsername, 'password' => request()->password], $remember)) {
            request()->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return back()->with('errorAlert', 'Maaf, email/username atau password yang anda masukkan salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('toast_success', 'Anda berhasil logout!');
    }
}
