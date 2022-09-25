@extends('layouts.main')
{{-- include layouts/main.blade.php | Pathnya relative terhadap folder views | Laravel Blade Directive --}}
{{-- @extends() akan memuat filenya di paling bawah --}}

{{-- Ini akan menggantikan @yield('dinamis') yang ada di layouts.main --}}
@section('dinamis')
<h1 class="mt-3 text-light">Hello World!</h1>
@endsection