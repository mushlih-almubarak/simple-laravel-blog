<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all()
    {
        return view('categories', [
            'title' => 'Semua Kategori',
            'categories' => Category::all()
        ]);
    }
}
