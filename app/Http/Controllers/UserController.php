<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function all()
    {
        return view('authors', [
            'title' => 'Semua Penulis',
            'authors' => User::latest()->get()
        ]);
    }

    public function userList()
    {
        return view('userList', [
            'title' => 'Semua Pengguna',
            'users' => User::latest()->paginate(10)->withQueryString()
        ]);
    }
}
