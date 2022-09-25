@extends('layouts.main')
@section('dinamis')
{{-- Cek apakah ada artikel --}}
@if ($posts->count() > 0)
<div class="container mx-auto mt-5">
    <h2 class="text-center text-light mb-5">Semua Artikel</h2>
    <form class="mb-5">
        <div class="input-group mb-3">
            <div class="form-floating form-floating-group flex-grow-1">
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                <input type="hidden" name="penulis" value="{{ request('penulis') }}">
                <input type="text" value="{{ request('cari') }}" class="form-control" name="cari"
                    aria-describedby="button-addon2" id="floatingInput" placeholder="Cari artikel...">
                <label for="floatingInput">Cari artikel...</label>
            </div>
            <button class="btn px-5" type="submit" id="button-addon2">Cari</button>
        </div>
    </form>
    <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-4">
            <div class="card">
                <a href="/blog?kategori={{ $post->category->slug }}"
                    class="position-absolute px-3 py-2 text-light bg-transparant">{{
                    $post->category->name }}</a>
                <a href="/blog/{{ $post->slug }}">
                    <img src="{{ ($post->image) ? asset('storage/' . $post->image) : asset('img/no-image-posts.png') }}"
                        class="card-img-top img-fluid" alt="{{ $post->category->name }}">
                </a>
                <div class="card-body">
                    <a href="/blog/{{ $post->slug }}" class="text-decoration-none">
                        <h5 class="card-title ">{{ $post->title }}</h5>
                    </a>
                    <small>Oleh
                        <a href="/blog?penulis={{ $post->author->username }}">{{ $post->author->name
                            }}</a>.
                        <span>{{ str_replace('day', 'hari', str_replace('hour', 'jam', str_replace('minute',
                            'menit',
                            str_replace('minutes',
                            'menit', str_replace('seconds',
                            'detik', str_replace('hours',
                            'jam',str_replace('ago', 'yang lalu',
                            $post->created_at->diffForHumans())))))))
                            }}</span>
                    </small>
                    <p class="card-text mt-3 text-light">{{ $post->excerpt }}</p>
                    <a href="/blog/{{  $post->slug }}" class="btn text-bold">Baca Selengkapnya...</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<h2 class="text-light mt-5 text-center">Maaf, tidak ada artikel yang ditemukan</h2>
@endif
{{ $posts->links() }}
@endsection