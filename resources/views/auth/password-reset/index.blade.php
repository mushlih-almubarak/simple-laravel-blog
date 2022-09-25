@extends('layouts.main')
@section('dinamis')
@if($errors->get('email'))
@php Alert::error('Gagal', $errors->get('email')) @endphp
@endif
@if(session()->has('successAlert'))
@php Alert::success('Berhasil', session('successAlert')) @endphp
@endif

<h2 class="text-light mb-3 mt-3">Reset Password</h2>
<form action="/lupa-password" method="post">
    @csrf
    <div class="input-group mb-3">
        <div class="form-floating form-floating-group flex-grow-1">
            <input type="email" required value="{{ old('email') }}"
                class="@error('email') is-invalid @enderror form-control" name="email" id="email"
                placeholder="Masukkan email">
            <label for="email">Masukkan email anda</label>
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button class="btn px-5" type="submit" id="button-addon2">Kirim Link</button>
    </div>
</form>
@endsection