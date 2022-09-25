@extends('dashboard.layouts.main')
@section('dinamis')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Artikel Saya</h1>
</div>
@if(session()->has('successAlert'))
@php Alert::success('Berhasil', session('successAlert')) @endphp
@endif
@if(session()->has('errorAlert'))
@php Alert::error('Gagal', session('errorAlert')) @endphp
@endif

@if ($posts->count() > 0)
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ !request('status') ? 'border border-2 border-bottom-0 border-primary' : '' }}"
            href="/dashboard/artikel">Semua</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'diterbitkan' ? 'border border-2 border-bottom-0 border-primary' : ''}}"
            href="?status=diterbitkan">Diterbitkan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'draft' ? 'border border-2 border-bottom-0 border-primary' : ''}}"
            href="?status=draft">Draft</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'dihapus' ? 'border border-2 border-bottom-0 border-primary' : ''}}"
            href="?status=dihapus">Dihapus</a>
    </li>
</ul>
<div class="table-responsive col-lg-12">
    <table class="table table-bordered border-dark table-striped table-sm">
        <thead class="bg-primary text-light">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Judul</th>
                <th scope="col">Kategori</th>
                <th scope="col">Tanggal Dibuat</th>
                <th scope="col">Excerpt</th>
                <th scope="col" class="{{ request('status') ? 'd-none' : '' }}">Status</th>
                <th scope="col" class="{{ request('status') !== 'dihapus' ? 'd-none' : '' }}">Tanggal Dihapus</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td>{{ ($posts->currentpage()-1) * $posts->perpage() + $loop->iteration }}.</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category->name }}</td>
                <td class="col-2">{{ $post->created_at->format('d-m-Y') }}</td>
                <td>{!! $post->excerpt !!}</td>
                <td class="{{ request('status') ? 'd-none' : '' }}">{{ $post->status }}</td>
                <td class="{{ request('status') !== 'dihapus' ? 'd-none' : '' }}">{{ $post->deleted_at ?
                    $post->deleted_at->format('d-m-Y') : ''
                    }}</td>
                <td class="col-2">
                    <a href="/blog/{{ $post->slug }}" class="badge bg-primary me-1">
                        <span data-feather="eye"></span>
                    </a>
                    <a href="/dashboard/artikel/{{ $post->slug }}/edit"
                        class="badge bg-warning me-1 {{ $post->status === 'Dihapus' ? 'd-none' : ''}}">
                        <span data-feather="edit"></span>
                    </a>
                    <form action="/dashboard/artikel/{{ $post->slug }}"
                        class="d-inline {{ $post->status !== 'Dihapus' ? 'd-none' : ''}}" method="post">
                        @method('put')
                        @csrf
                        <input type="hidden" name="status" value="draft">
                        <button class="badge bg-warning me-1 border-0" type="button"
                            onclick="restoreFromTrashConfirmation(this.parentElement)">
                            <span data-feather="refresh-ccw"></span>
                        </button>
                    </form>
                    <form action="/dashboard/artikel/{{ $post->slug }}" class="d-inline" method="post">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" type="button"
                            onclick="confirmDeleteOrNot(this.parentElement, 'artikel'@if($post->status !== 'Dihapus'), 'Ini akan memindahkan artikel Anda ke tempat sampah, Anda bisa mengembalikannya kapanpun'@endif)">
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
<a href="/dashboard/artikel/buat-baru" class="btn btn-primary mb-3">Buat Artikel Baru</a>
@endsection