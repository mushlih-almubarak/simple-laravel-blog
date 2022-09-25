@extends('dashboard.layouts.main')

@section('dinamis')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Kategori</h1>
</div>
@if(session()->has('successAlert'))
@php Alert::success('Berhasil', session('successAlert')) @endphp
@endif
@if(session()->has('errorAlert'))
@php Alert::error('Gagal', session('errorAlert')) @endphp
@endif

@if ($categories->count() > 0)
<div class="table-responsive col-lg-12">
    <table class="table table-bordered border-dark table-striped table-sm">
        <thead class="bg-primary text-light">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Kategori</th>
                <th scope="col">Tanggal Dibuat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ ($categories->currentpage()-1) * $categories->perpage() + $loop->iteration }}.</td>
                <td>{{ $category->name }}</td>
                <td class="col-2">{{ $category->created_at->format('d-m-Y') }}</td>
                <td class="col-2">
                    <a href="/dashboard/kategori/{{ $category->slug }}" class="badge bg-primary me-1">
                        <span data-feather="eye"></span>
                    </a>
                    <a href="/dashboard/kategori/{{ $category->slug }}/edit" class="badge bg-warning me-1">
                        <span data-feather="edit"></span>
                    </a>
                    <form action="/dashboard/kategori/{{ $category->slug }}" class="d-inline" method="post">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" type="button"
                            onclick="confirmDeleteOrNot(this.parentElement, 'kategori')">
                            <span data-feather="x-circle"></span>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>
@else
<h2 class="text-center">Maaf, tidak ada kategori yang ditemukan</h2>
@endif
<hr>
<a href="/dashboard/kategori/buat-baru" class="btn btn-primary mb-3">Buat Kategori Baru</a>
@endsection