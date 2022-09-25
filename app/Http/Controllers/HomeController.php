<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $posts = \App\Models\Post::where('status', 'published')->get();
        // foreach ($posts as $post) {
        //     $post->update(['deleted_at' => null]);
        // }
        // $posts = \App\Models\Post::where('status', 'draft')->get();
        // foreach ($posts as $post) {
        //     $post->update(['deleted_at' => null]);
        // }
        // $posts = \App\Models\Post::where('status', 'deleted')->get();
        // foreach ($posts as $post) {
        //     $post->update(['deleted_at' => now()]);
        // }

        // $posts = \App\Models\Post::where('status', 'published')->get();
        // foreach ($posts as $post) {
        //     $post->update(['published_at' => now()]);
        // }
        // $posts = \App\Models\Post::where('status', 'draft')->get();
        // foreach ($posts as $post) {
        //     $post->update(['published_at' => null]);
        // }
        // $posts = \App\Models\Post::where('status', 'deleted')->get();
        // foreach ($posts as $post) {
        //     $post->update(['published_at' => null]);
        // }
        return view('home', [
            'title' => 'Beranda'
        ]);
    }
}
