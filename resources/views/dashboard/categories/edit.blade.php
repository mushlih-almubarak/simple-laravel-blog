@extends('dashboard.layouts.main')
@section('dinamis')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Kategori</h1>
</div>

@if(session()->has('errorAlert'))
@php Alert::error('Gagal', session('errorAlert')) @endphp
@endif

<div class="col-lg-10">
    <form action="/dashboard/kategori/{{ $category->slug }}" method="post">
        @method('put')
        @csrf
        <div class="mb-3">
            <label for="categoryName" class="form-label">Judul Kategori</label>
            <input required type="text" class="form-control @error('categoryName')is-invalid @enderror" id="title"
                name="categoryName" value="{{ old('categoryName', $category->name) }}">
            @error('categoryName')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <label for="slug" class="form-label">URL Kategori</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">{{ url('/') }}/blog?kategori=</span>
            <input required type="text" name="slug" class="form-control @error('slug')is-invalid @enderror" id="slug"
                value="{{ old('slug', $category->slug) }}">
            @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="d-flex justify-content-end mb-3">
            <button type="submit" class="btn btn-primary">Update Kategori</button>
        </div>
    </form>
</div>
@endsection