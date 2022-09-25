@extends('layouts.main')
@section('dinamis')

@if(Session::has('errorAlert'))
@php alert()->error('Gagal', session('errorAlert')); @endphp
@endif
<section class="overflow-hidden">
    <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    <span style="color: hsl(218, 81%, 75%)">Buat akun baru.</span>
                </h1>
                <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Temporibus, expedita iusto veniam atque, magni tempora mollitia
                    dolorum consequatur nulla, neque debitis eos reprehenderit quasi
                    ab ipsum nisi dolorem modi. Quos?
                </p>
            </div>

            <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                <div class="card">
                    <div class="card-body px-4 py-5 px-md-5">
                        <form method="post">
                            {{-- Mengirimkan token dengan input hidden untuk memvalidasi agar form yang dikirim memang
                            dari halaman ini --}}
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" required class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Nama" value="{{ old('name') }}">
                                <label for="nama">Nama</label>
                                {{-- Jika ada error di inputan 'name', tampilkan: --}}
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" required class="form-control @error('username') is-invalid @enderror"
                                    name="username" id="username" placeholder="Username" value="{{ old('username') }}">
                                <label for="username">Username</label>
                                @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" required class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                                <label for="email">Email</label>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" required
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    id="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" required
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password_confirmation" id="password_confirmation"
                                    placeholder="Konfirmasi Password" onpaste="return preventPaste()">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-block mb-4">Daftar</button>
                            </div>

                            <!-- Login buttons -->
                            <div class="text-center text-lg-start mt-4 pt-2">
                                <p class="small fw-bold mt-2 pt-1 mb-0">Sudah punya akun? <a href="/login"
                                        class="warna-utama">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection