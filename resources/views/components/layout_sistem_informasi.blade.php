<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    {{-- Vite CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

    <div x-data="{ sidebarOpen: false }">

        <!-- Tombol buka sidebar -->
        <button @click="sidebarOpen = true"
            class="bg-[#31333B] text-white px-4 py-3 w-full flex items-center justify-between shadow-md">
            <span class="font-bold">☰ Menu</span>
        </button>

        <!-- Overlay Blur (klik untuk menutup) -->
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-40">
        </div>

        <!-- Sidebar -->
        <div x-show="sidebarOpen" x-transition:enter="transform transition duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" x-cloak
            class="fixed inset-y-0 left-0 w-64 bg-[#31333B] text-white z-50 shadow-lg">
            <x-sidebar />
        </div>

        <!-- Main content -->
        <div class="p-4">
            {{ $slot }}
        </div>
    </div>



    {{-- SweetAlert2 --}}
    @include('sweetalert2::index')

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Trix JS --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    {{-- Flowbite JS --}}
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>

    {{-- Custom Script Stack --}}
    @stack('scripts')

</body>

</html>
