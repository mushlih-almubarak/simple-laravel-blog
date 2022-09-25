<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DashboardPostsController extends Controller
{
    public function getIP()
    {
        // return request()->ip();
        return file_get_contents('https://api.ipify.org');
    }

    public function getCountry()
    {
        $file = file_get_contents('https://www.iplocate.io/api/lookup/' . $this->getIP());
        return json_decode($file, true)['country'];
    }

    public function getCity()
    {
        $file = file_get_contents('https://www.iplocate.io/api/lookup/' . $this->getIP());
        return json_decode($file, true)['city'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('status') === 'diterbitkan') {
            $posts = Post::by(['penulis' => auth()->user()->username, 'cari' => request('cari')])->where('status', 'published')->latest()->paginate(10)->withQueryString();
        } elseif (request('status') === 'draft') {
            $posts = Post::by(['penulis' => auth()->user()->username, 'cari' => request('cari')])->where('status', 'draft')->latest()->paginate(10)->withQueryString();
        } elseif (request('status') === 'dihapus') {
            $posts = Post::by(['penulis' => auth()->user()->username, 'cari' => request('cari')])->where('status', 'deleted')->latest()->paginate(10)->withQueryString();
        } else {
            $posts = Post::by(['penulis' => auth()->user()->username, 'cari' => request('cari')])->latest()->paginate(10)->withQueryString();
        }

        $i = 0;
        // Ubah string yang dari database
        foreach ($posts as $post) {
            $posts[$i]->status = str_replace('published', 'Diterbitkan', $post->status);
            $posts[$i]->status = str_replace('draft', 'Draft', $post->status);
            $posts[$i]->status = str_replace('deleted', 'Dihapus', $post->status);
            $i++;
        }

        return view('dashboard.posts.index', [
            'title' => 'Semua Artikel Saya',
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'title' => 'Buat Artikel Baru',
            'categories' => Category::all()
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
        // Ubah slug ke lower
        $request['slug'] = strip_tags($request['slug']);
        $request['slug'] = Str::lower($request->slug);
        // Cek apakah ada slug yang sama
        foreach (Post::all('slug') as $check) {
            if ($check['slug'] == $request->slug) {
                $request['slug'] = $request->slug . '-' . Str::lower(Str::random(5));
            }
        };

        $rules = [
            'title' => ['required', 'max:255'],
            'slug' => ['required', 'unique:posts'],
            'category_id' => ['required', 'numeric'],
            'body' => ['required', 'min:50'],
            'status' => ['required', 'regex:(published|draft)'],
        ];

        if ($request->file('image')) {
            // Buat rules
            $rules['image'] = ['image', 'mimes:jpeg,png,jpg', 'max:1024'];
            // Ambil nama file
            $name = pathinfo($request->file('image')->getClientOriginalName())['filename'];
            // Ambil ekstentsi file
            $exstention = '.' . $request->file('image')->getClientOriginalExtension();
            // Buat file baru
            $file = $name . '-' . now()->format('d-m-Y') . '-' . now()->format('s') . Str::random(3) . $exstention;
        }

        try {
            $validated = $request->validate($rules);
        } catch (Exception) {
            return redirect('/dashboard/artikel/buat-baru')->with('toast_error', 'Harap perbaiki bidang-bidang yang salah!')->withErrors($request->validate($rules))->withInput();
        };

        if ($request->category_id > count(Category::all())) {
            $request['category_id'] = 1;
        }
        $validated['user_id'] = auth()->user()->id;
        $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 80);
        $validated['created_at_ip_address'] = $this->getIP();
        $validated['created_at_country'] = $this->getCountry();
        $validated['created_at_city'] = $this->getCity();
        if ($request->file('image')) {
            // Simpan gambar
            $validated['image'] = $request->file('image')->storeAs('img', $file);
        };

        $status = $request->status === 'draft' ? 'disimpan sebagai draft' : 'diterbitkan';
        try {
            $post = Post::create($validated);
            $request->status === 'published' ? Post::find($post->id)->update(['published_at' => now()]) : '';
            return redirect('/dashboard/artikel')->with('successAlert', 'Selamat! artikel Anda berhasil ' . $status . '!');
        } catch (Exception) {
            return back()->withInput()->with('errorAlert', 'Maaf! artikel Anda gagal dibuat, harap coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $artikel)
    {
        if ($artikel->status === 'deleted') {
            return redirect('/dashboard/artikel')->with('errorAlert', 'Maaf! artikel Anda tidak dapat diedit karena telah dihapus.');
        }

        if (Gate::check('manage-posts', $artikel) || Gate::check('all-actions')) {
            return view('dashboard.posts.edit', [
                'title' => 'Edit Artikel',
                'post' => $artikel,
                'status' => str_replace('published', 'Diterbitkan', str_replace('draft', 'Draft', $artikel->status)),
                'categories' => Category::all()
            ]);
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $artikel)
    {
        if ($artikel->status === 'deleted') {
            if ($request->status === 'draft') {
                $artikel->update(
                    [
                        'status' => 'draft',
                        'deleted_at' => null
                    ]
                );
                return redirect('/dashboard/artikel')->with('successAlert', 'Artikel Anda berhasil dikembalikan dari tempat sampah.');
            }
            return abort(403);
        }

        // Ubah slug ke lower
        $request['slug'] = strip_tags($request->slug);
        $request['slug'] = Str::lower($request->slug);

        $rules = [];
        // Cek apa saja yang diubah
        if ($request->title !== $artikel->title) {
            $rules['title'] = ['required', 'max:255'];
        }
        if ($request->slug !== $artikel->slug) {
            $rules['slug'] = ['required', 'unique:posts'];
        }
        if ($request->status !== $artikel->status) {
            $rules['status'] = 'regex:(published|draft)';
        }
        if ($request->file('image')) {
            // Buat rules
            $rules['image'] = ['image', 'mimes:jpeg,png,jpg', 'max:1024'];
            // Ambil nama file
            $name = pathinfo($request->file('image')->getClientOriginalName())['filename'];
            // Ambil ekstentsi file
            $exstention = '.' . $request->file('image')->getClientOriginalExtension();
            // Buat file baru
            $file = $name . '-' . now()->format('d-m-Y') . '-' . now()->format('s') . Str::random(3) . $exstention;
        }
        if ($request->category_id != $artikel->category_id) {
            $rules['category_id'] = ['required', 'numeric'];
        }
        if ($request->body !== $artikel->body) {
            $rules['body'] = ['required'];
        }

        // Validasi
        try {
            $validated = $request->validate($rules);
        } catch (Exception) {
            return back()->with('toast_error', 'Harap perbaiki bidang-bidang yang salah!')->withErrors($request->validate($rules));
        }

        if ($request->category_id > count(Category::all())) {
            $request['category_id'] = 5;
        }
        if ($request->body !== $artikel->body) {
            $validated['excerpt'] = Str::limit(strip_tags($request->body), 80);
        }
        if ($request->file('image')) {
            // Hapus gambar lama jika ada
            if ($artikel->image) {
                Storage::delete($artikel->image);
            };
            // Simpan gambar
            $validated['image'] = $request->file('image')->storeAs('img', $file);
        };
        if ($request->status !== $artikel->status) {
            $validated['status'] === 'published' ? $validated['published_at'] = now() : $validated['published_at'] = null;
        }

        try {
            Post::find($artikel->id)->update($validated);
            return redirect('/dashboard/artikel')->with('successAlert', 'Artikel anda berhasil diupdate!');
        } catch (Exception) {
            return back()->withInput()->with('errorAlert', 'Maaf, artikel anda gagal diupdate!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $artikel)
    {
        if (Gate::check('manage-posts', $artikel) || Gate::check('all-actions')) {
            if ($artikel->status !== 'deleted') {
                $artikel->update([
                    'status' => 'deleted',
                    'deleted_at' => now()
                ]);
                return redirect('/dashboard/artikel')->with('successAlert', 'Artikel anda berhasil dipindahkan ke tempat sampah!');
            }

            try {
                // Hapus gambar jika ada
                if ($artikel->image) {
                    Storage::delete($artikel->image);
                };
                $artikel->delete();

                return redirect('/dashboard/artikel')->with('successAlert', 'Artikel anda berhasil dihapus!');
            } catch (Exception) {
                return redirect('/dashboard/artikel')->with('errorAlert', 'Artikel anda gagal dihapus!');
            }
        }
        return abort(403);
    }

    public function deleteImage(Post $post)
    {
        if (Gate::check('all-actions') || Gate::check('manage-posts', $post)) {
            if ($post->image) {
                Storage::delete($post->image);
                $post->update(['image' => null]);
            }
            return response()->json(['status' => 'success']);
        }
        return abort(403);
    }

    public function addImage(Request $request)
    {
        if ($request->has('image')) {
            $request->validate([
                'image' => ['image', 'mimes:jpeg,png,jpg', 'max:1024']
            ]);
            $imgName = pathinfo($request->file('image')->getClientOriginalName())['filename'];
            $exstention = '.' . $request->file('image')->getClientOriginalExtension();
            $fileName = $imgName . '-' . now()->format('d-m-Y') . '-' . now()->format('s') . Str::random(3) . $exstention;
            $url = $request->image->storeAs('img', $fileName);
            $url = url('/storage') . '/' . $url;
            return response()->json(['url' => $url]);
        }
        return abort(403);
    }
}
