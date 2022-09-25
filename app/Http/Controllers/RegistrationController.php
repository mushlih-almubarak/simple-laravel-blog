<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller
{
    public function getIP()
    {
        // return request()->ip();
        return file_get_contents('https://api.ipify.org');
    }

    public function getCountry()
    {
        $file = file_get_contents('http://ip-api.com/json/' . $this->getIP());
        return json_decode($file, true)['country'];
    }

    public function getCity()
    {
        $file = file_get_contents('http://ip-api.com/json/' . $this->getIP());
        return json_decode($file, true)['city'];
    }

    public function index()
    {
        return view('registration.index', [
            'title' => 'Daftar'
        ]);
    }

    public function store()
    {
        // Rules
        $rules = [
            // field 'nama' wajib diisi, maksimal 100 kata, hanya boleh huruf dan spasi yang dimasukkan 
            'name' => ['required', 'max:50', 'regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/'],
            // Field 'username' harus unik, tidak boleh ada yang sama dari yang ada di tabel database 'user', hanya boleh huruf kecil/besar dan angka dan dash dan underscore 
            'username' => ['required', 'min:4', 'max:15', 'unique:users', 'regex:/^[a-zA-Z0-9-_.]+$/'],
            // Harus ada kata gmail atau outlook atau yahoo di field 'email'
            'email' => ['required', 'unique:users', 'email:dns', 'regex:(@gmail.com|@outlook|@yahoo|@icloud.com)'],
            // Harus ada minimal satu huruf besar, dan minimal satu huruf kecil, dan minimal satu angka
            'password' => ['required', 'min:5', 'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/', 'confirmed']
        ];

        // validasi
        try {
            $validated = request()->validate($rules);
        } catch (Exception) {
            return back()->withInput()->with('toast_error', 'Harap perbaiki bidang-bidang yang salah!')->withErrors(request()->validate($rules));
        }

        // Jadikan usernamenya huruf kecil
        $validated['username'] = Str::lower($validated['username']);
        // // Hash password
        $validated['password'] = Hash::make($validated['password']);
        $validated['ip_address'] = $this->getIP();
        $validated['country'] = $this->getCountry();
        $validated['city'] = $this->getCity();
        // Masukkan ke database
        try {
            $user = User::create($validated);
            event(new Registered($user)); // Mengirim email verifikasi
            Auth::loginUsingId($user->id);
            // Redirect dan kirimkan session untuk flash message
            // with() == request()->session()->flash('success', 'Pendaftaran berhasil! Silakan login');
            return redirect('/email/verifikasi')->with('successAlert', 'Pendaftaran berhasil! Silakan verifikasi email anda');
        } catch (Exception) {
            return back()->withInput()->with('errorAlert', 'Terjadi kesalahan saat menyimpan data, silakan coba lagi');
        }
    }
}
