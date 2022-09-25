<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $title = 'Semua Artikel';

        if (request('kategori')) {
            $category = Category::firstWhere('slug', request('kategori'));
            $title = ($category) ? 'Kategori: ' . $category->name : 'Kategori tidak ditemukan';
        }

        if (request('penulis')) {
            $author = User::firstWhere('username', request('penulis'));
            $title = 'Penulis: ' . $author->name;
        }

        if (request('cari')) {
            $title = 'Hasil Pencarian: ' . request('cari');
        }

        return view('posts', [
            'title' => $title,
            'posts' => Post::where('status', 'published')->by(request(['kategori', 'penulis', 'cari']))->latest()->paginate(9)->withQueryString()
        ]);
    }

    public function post(Post $data)
    {
        return view(
            'post',
            [
                'title' => $data->title,
                'post' => $data,
                'url' => explode("//", url('/'))[1]
            ]
        );
    }
}
