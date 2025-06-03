<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    {{-- Vite CSS --}}
    @vite('resources/css/app.css')

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro&display=swap" rel="stylesheet">

    {{-- Trix Editor CSS --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

    {{-- Custom Styles Stack --}}
    @stack('styles')
</head>

<body style="overflow-y:auto" class="font-[Kantumruy_Pro] bg-gray-100">

    {{-- Navbar --}}
    <x-navbar></x-navbar>

    {{-- Main Content --}}
    <div class="flex">
        <x-sidebar></x-sidebar>
        {{ $slot }}
    </div>

    {{-- SweetAlert2 --}}
    @include('sweetalert2::index')

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Trix JS --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    {{-- Custom Script Stack --}}
    @stack('scripts')

</body>

</html>
