@extends('layouts.main')

@section('dinamis')
@if($errors->get('password'))
@php Alert::error('Gagal', $errors->get('password')) @endphp
@endif

<h2 class="text-light mb-3 mt-3">Buat Password Baru</h2>
<form action="/password/reset/{{ $token }}" method="post">
    @csrf
    <div class="input-group mb-3">
        <div class="form-floating form-floating-group flex-grow-1">
            <input type="hidden" required name="token" value="{{ $token }}">
            <input type="hidden" required name="email" value="{{ $email }}">
            <input type="password" required class="form-control @error('password') is-invalid @enderror" name="password"
                id="password" placeholder="Masukkan password baru anda...">
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <label for="password">Buat password baru</label>
        </div>
        <div class="form-floating form-floating-group flex-grow-1">
            <input type="password" required class="form-control @error('password') is-invalid @enderror"
                name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password baru anda...">
            <label for="password_confirmation">Konfirmasi password baru</label>
        </div>
        <button class="btn px-5" id="button-addon2">Update Password</button>
    </div>
</form>
@endsection