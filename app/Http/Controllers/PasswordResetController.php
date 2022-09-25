<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('auth.password-reset.index', ['title' => 'Reset Password']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT ? back()->with('successAlert', __($status)) : back()->withInput()->withErrors(['email' => __($status), 'errorAlert' => __($status)]);
    }

    public function updateGet($token, Request $request)
    {
        return view('auth.password-reset.reset', [
            'title' => 'Buat Password Baru',
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'min:5', 'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/', 'confirmed']
        ]);

        $status = PASSWORD::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->update(['password' => bcrypt($password)]);
            event(new PasswordReset($user));
        });

        return $status === PASSWORD::PASSWORD_RESET ? redirect('/login')->with('successAlert', __($status)) : back()->withErrors(['password' => __($status)]);
    }
}
