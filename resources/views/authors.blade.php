@extends('layouts.main')
@section('dinamis')
<div class="container">
    <div class="row my-5 justify-content-center">
        <h1 class="text-center mb-5">Semua Penulis</h1>
        @foreach ($authors as $author)
        <div class="col-md-3 my-3">
            <a href="/blog?penulis={{ $author->username }}">
                <div class="card bg-dark text-white">
                    <img src="{{ url('/img/' . $author->profile) }}" class="card-img"
                        alt="{{ $author->name }} profile image">
                    <div class="card-img-overlay d-flex" style="background: rgba(0, 0, 0, 0.4)">
                        <h3 class="card-title m-auto">{{ $author->name }}</h3>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="row justify-content-center text-center">
        <div class="col-md-3">
            <a href="/blog">
                <button class="btn btn-dark text-light justify-content-center">Kembali ke list
                    artikel</button>
            </a>
        </div>
    </div>
    <br><br>
</div>
@endsection