<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function GuzzleHttp\Promise\all;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.categories.index', [
            'title' => 'Kelola Kategori',
            'categories' => Category::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create', [
            'title' => 'Tambah Kategori'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['slug'] = Str::lower($request->slug);
        $validated = $request->validate([
            'categoryName' => ['unique:categories,name', 'required', 'max:255', 'string'],
            'slug' => ['unique:categories', 'required', 'max:255', 'string']
        ]);
        $validated['name'] = $validated['categoryName'];
        unset($validated['categoryName']);

        Category::create($validated);
        return redirect('/dashboard/kategori')->with('successAlert', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $kategori)
    {
        return view('dashboard.categories.single', [
            'title' => 'Kategori: ' . $kategori->name,
            'heading_title' => (request('cari')) ? 'Hasil Pencarian dari: "' . request('cari') . '" di kategori: ' . $kategori->name : 'Semua artikel dengan kategori: ' . $kategori->name,
            'posts' => $kategori->post->toQuery()->by(request(['cari']))->latest()->with('author')->paginate(10)->withQueryString()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $kategori)
    {
        return view('dashboard.categories.edit', [
            'title' => 'Tambah Kategori',
            'category' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $kategori)
    {
        $request['slug'] = Str::lower($request->slug);
        $rules = [];
        if ($request['slug'] !== $kategori->slug) {
            $rules['slug'] = ['unique:categories', 'required', 'max:255', 'string'];
        }
        if ($request['categoryName'] !== $kategori->name) {
            $rules['categoryName'] = ['unique:categories,name', 'required', 'max:255', 'string'];
        }

        $validated = $request->validate($rules);
        $validated['name'] = $validated['categoryName'];
        unset($validated['categoryName']);

        $kategori->update($validated);
        return redirect('/dashboard/kategori')->with('successAlert', 'Kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $kategori)
    {
        // Check if an article have this category
        if ($kategori->post->count() > 0) {
            foreach ($kategori->post as $post) {
                $post->update(['category_id' => 1]);
            }
        }
        $kategori->delete();
        return redirect('/dashboard/kategori')->with('successAlert', 'Kategori berhasil dihapus');
    }
}
