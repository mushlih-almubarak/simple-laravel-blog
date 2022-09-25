@extends('layouts.main')
@section('dinamis')
@if(session()->has('successAlert'))
@php Alert::success('Berhasil', session('successAlert')) @endphp
@endif
<h2 class="text-light">Harap Verifikasikan Email Anda</h2>
<p class="text-muted">Klik link yang kami kirimkan ke email anda untuk memverifikasikan email anda</p>
<form action="/email/verifikasi" method="post">
    @csrf
    <button class="btn btn-primary verifikasi-email">Kirim ulang</button>
</form>
@endsection