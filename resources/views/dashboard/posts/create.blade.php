@extends('dashboard.layouts.main')
@section('dinamis')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Artikel Baru</h1>
</div>

@if(session()->has('errorAlert'))
@php Alert::error('Gagal', session('errorAlert')) @endphp
@endif
<div class="col-lg-10">
    <form action="/dashboard/artikel" method="post" enctype="multipart/form-data" id="form">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul Artikel</label>
            <input required type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                name="title" value="{{ old('title') }}">
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
                value="{{ old('slug') }}">
            @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Artikel</label>
            <img class="img-preview mb-3 col-sm-5">
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
                <option value="{{ $category->id }}" {{ (old('category_id')==$category->id ||
                    request('kategori') == $category->id) ?
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
                value="{{ old('body') }}">
            @error('body')
            <div class="invalid-feedback mb-2">
                {{ $message }}
            </div>
            @enderror
            <trix-editor input="editor" id="text-editor"></trix-editor>
        </div>
        <input type="hidden" id="status" name="status" value="draft">
        <div class="d-flex justify-content-end mb-3">
            <button type="submit" class="btn btn-primary me-3">Simpan Sebagai
                Draft</button>
            <button type="button" onclick="publish()" class="btn btn-primary">Buat Artikel</button>
        </div>
    </form>
</div>
@endsection