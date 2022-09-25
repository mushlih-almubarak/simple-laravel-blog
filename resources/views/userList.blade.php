@extends('dashboard.layouts.main')
@section('dinamis')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Semua Pengguna</h1>
</div>

@if ($users->count() > 0)
<div class="table-responsive col-lg-12">
    <table class="table table-bordered border-dark table-striped table-sm">
        <thead class="bg-primary text-light">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Negara</th>
                <th scope="col">Kota</th>
                <th scope="col">Tanggal Dibuat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ ($users->currentpage()-1) * $users->perpage() + $loop->iteration }}.</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->country }}</td>
                <td>{{ $user->city }}</td>
                <td class="col-2">{{ $user->created_at->format('d-m-Y') }}</td>
                <td class="col-2">
                    <a href="/login-user/{{ $user->id }}" target="_blank" class="btn btn-primary">
                        <x-bi-box-arrow-in-right /> Login
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@else
<h2 class="text-center">Maaf, tidak ada pengguna yang ditemukan</h2>
@endif
@endsection