@extends('layouts.main')
@section('dinamis')
@if(session()->has('errorAlert'))
@php Alert::error('Gagal', session('errorAlert')) @endphp
@endif
@if(session()->has('successAlert'))
@php Alert::success('Berhasil', session('successAlert')) @endphp
@endif
<section class="overflow-hidden">
    <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    <span style="color: hsl(218, 81%, 75%)">Login.</span>
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
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" required name="emailOrUsername"
                                    class="form-control @error('emailOrUsername') is-invalid @enderror"
                                    id="emailOrUsername" placeholder="Email Atau Username" autofocus>
                                <label for="email">Email Atau Username</label>
                                @error('emailOrUsername')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <input type="password" required name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    placeholder="Password">
                                <label for="password">Password</label>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-center mt-3 mb-4">
                                <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" />
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <!-- Login button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-block mb-4">Login</button>
                            </div>

                            <!-- Register And Forgot Password buttons -->
                            <div class="text-center text-lg-start mt-4 pt-2">
                                <p class="small fw-bold mt-2 pt-1 mb-0">Belum punya akun? <a href="/daftar"
                                        class="warna-utama">Daftar</a></p>
                                <p class="small fw-bold mt-2 pt-1 mb-0">Lupa
                                    Password? <a href="/daftar" class="warna-utama">Reset Password Anda</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection