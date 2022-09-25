@extends('dashboard.layouts.main')

@section('dinamis')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Artikel: {{ $post->title }} ({{ $status }})</h1>
</div>

@if(session()->has('errorAlert'))
@php Alert::error('Gagal', session('errorAlert')) @endphp
@endif

<div class="col-lg-10">
    <form action="/dashboard/artikel/{{ $post->slug }}" method="post" id="form" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul Artikel</label>
            <input required type="text" class="form-control @error('title')is-invalid @enderror" id="title" name="title"
                value="{{ old('title', $post->title) }}">
            @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <label for="slug" class="form-label">URL Artikel</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">{{ url('/') }}/blog/</span>
            <input required type="text" name="slug" class="form-control @error('slug')is-invalid @enderror" id="slug"
                value="{{ old('slug', $post->slug) }}">
            @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Artikel</label>
            @if($post->image)
            <img class="img-preview mb-3 d-block col-sm-5" src="{{ asset('storage/' . $post->image) }}">
            {{-- Tombol hapus gambar --}}
            <button type="button" onclick="deleteImage(this)" class="btn btn-danger mb-3 btn-sm"
                id="btn-delete-image">Hapus
                Gambar</button>
            @else
            <img class="img-preview mb-3 col-sm-5">
            <button type="button" style="display: none" onclick="deleteImage(this)" class="btn btn-danger mb-3 btn-sm"
                id="btn-delete-image">Hapus
                Gambar</button>
            @endif
            <input class="form-control @error('image')is-invalid @enderror" type="file" name="image" id="image"
                onchange="previewImage()">
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select class="form-select @error('category_id')is-invalid @enderror" id="category" name="category_id">
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id', $post->category->id)==$category->id) ?
                    'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="text-editor" class="form-label">Isi Artikel</label>
            <input id="editor" type="hidden" name="body" class="@error('body')is-invalid @enderror" id="body"
                value="{{ old('body', $post->body) }}">
            @error('body')
            <div class="invalid-feedback mb-2">
                {{ $message }}
            </div>
            @enderror
            <trix-editor input="editor" id="text-editor"></trix-editor>
        </div>
        <input type="hidden" id="status" name="status" value="{{ $post->status }}">

        <div class="d-flex justify-content-end mb-3">
            @if($post->status === 'draft')
            <button type="submit" class="btn btn-primary me-3">Update Draft</button>
            <button type="button" class="btn btn-primary" onclick="publish()">Terbitkan Artikel</button>
            @endif
            @if($post->status === 'published')
            <button type="button" class="btn btn-primary me-3" onclick="publish('draft')">Update dan alihkan ke
                draft</button>
            <button type="submit" class="btn btn-primary">Update Artikel</button>
            @endif
        </div>
    </form>
</div>
@endsection