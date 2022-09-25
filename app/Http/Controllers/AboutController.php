<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Tampilkan view home, dan kirimkan parameter (akan dikembalikan langsung menggunakan nama variabel sesuai key yang ada di arraynya)
    public function index()
    {
        return view('about', [
            'title' => 'Tentang Saya'
        ]);
    }
}
