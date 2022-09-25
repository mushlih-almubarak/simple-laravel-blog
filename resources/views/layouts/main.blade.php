<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ (isset($title)) ? $title : $post->title }} | MSH Blog</title>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>

<body>
    {{-- @include() akan memuat filenya di baris tempat includenya ditelakkan --}}
    @include('partials.navbar')
    <div class="container">
        {{-- Bagian ini akan diganti sesuai yang dibuat di halaman childnya --}}
        @yield('dinamis')
    </div>
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    @yield('feather-icons')
    @include('sweetalert::alert')
    <script src="{{ asset('/js/script.js') }}"></script>
</body>

</html>