@extends('dashboard.layouts.main')

@section('dinamis')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $heading_title }}</h1>
</div>
@if(session()->has('successAlert'))
@php Alert::success('Berhasil', session('successAlert')) @endphp
@endif
@if(session()->has('errorAlert'))
@php Alert::error('Gagal', session('errorAlert')) @endphp
@endif

@if ($posts->count() > 0)
<div class="table-responsive col-lg-12">
    <table class="table table-bordered border-dark table-striped table-sm">
        <thead class="bg-primary text-light">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Judul</th>
                <th scope="col">Tanggal Dibuat</th>
                <th scope="col">Excerpt</th>
                <th scope="col">Penulis</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td>{{ ($posts->currentpage()-1) * $posts->perpage() + $loop->iteration }}.</td>
                <td>{{ $post->title }}</td>
                <td class="col-2">{{ $post->created_at->format('d-m-Y') }}</td>
                <td>{{ $post->excerpt }}</td>
                <td>{{ $post->author->name }}</td>
                <td class="col-2">
                    <a href="/blog/{{ $post->slug }}" class="badge bg-primary me-1">
                        <span data-feather="eye"></span>
                    </a>
                    <a href="/dashboard/artikel/{{ $post->slug }}/edit" class="badge bg-warning me-1">
                        <span data-feather="edit"></span>
                    </a>
                    <form action="/dashboard/artikel/{{ $post->slug }}" class="d-inline" method="post">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" type="button"
                            onclick="confirmDeleteOrNot(this.parentElement, 'artikel')">
                            <span data-feather="x-circle"></span>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $posts->links() }}
</div>
@else
<h2 class="text-center">Maaf, tidak ada artikel yang ditemukan</h2>
@endif
<hr>
<a href="/dashboard/artikel/buat-baru?kategori={{ (isset($posts[0])) ? $posts[0]->category->id : '' }}"
    class="btn btn-primary mb-3">Buat Artikel
    Baru</a>
<a href="/dashboard/kategori" class="btn btn-primary mb-3">Kembali Ke List Kategori</a>
@endsection