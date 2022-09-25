@extends('layouts.main')
@section('dinamis')
<div class="container">
    <div class="row my-5">
        <h1 class="text-center mb-5">Semua Kategori</h1>
        @foreach ($categories as $category)
        <div class="col-md-3 my-3">
            <a href="/blog?kategori={{ $category->slug }}">
                <div class="card bg-dark text-white">
                    <img src="https://source.unsplash.com/500x400?{{ $category->name }}" class="card-img"
                        alt="{{ $category->name }}">
                    <div class="card-img-overlay d-flex" style="background: rgba(0, 0, 0, 0.5)">
                        <h3 class="card-title m-auto">{{ $category->name }}</h3>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <a href="/blog"><button class="btn btn-dark text-light">Kembali ke list artikel</button></a>
    <br><br>
</div>
@endsection