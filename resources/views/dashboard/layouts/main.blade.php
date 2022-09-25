<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | MSH Web {{ (Request::is('dashboard')) ? '' : 'Dashboard' }}</title>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/trix.css') }}">
    @if(Request::is('dashboard/artikel/buat-baru') || Request::is('dashboard/artikel/*/edit'))
    <script src="{{ asset('/js/trix.js') }}"></script>
    @endif
</head>

<body>

    @include('dashboard.layouts.header')
    <div class="container-fluid">
        <div class="row">
            @include('dashboard.layouts.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('dinamis')
            </main>
        </div>
    </div>

    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/feather.min.js') }}"></script>
    <script src="{{ asset('/js/dashboard.js') }}"></script>
    @include('sweetalert::alert')
    <script src="{{ asset('/js/script.js') }}"></script>
    @if(Request::is('dashboard/artikel/buat-baru') || Request::is('dashboard/artikel/*/edit') ||
    Request::is('dashboard/kategori/buat-baru') || Request::is('dashboard/kategori/*/edit'))
    <script>
        changeURL();
    </script>
    @endif
</body>

</html>