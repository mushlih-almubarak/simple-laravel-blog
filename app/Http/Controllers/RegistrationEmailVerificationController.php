<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\GreetingNewUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class RegistrationEmailVerificationController extends Controller
{
    public function index()
    {
        return view('auth.verify-email', ['title' => 'Verifikasi Email']);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        Mail::to(auth()->user()->email)->send(new GreetingNewUser(auth()->user()->name));
        return redirect('/dashboard')->with('successAlert', 'Email Anda berhasil diverifikasi');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification(); // Kirim ulang link verifikasi
        return back()->with('successAlert', 'Email verifikasi berhasil di kirim ulang.');
    }
}
