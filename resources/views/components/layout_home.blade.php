<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</head>

<body style="font-family: 'Kantumruy Pro', sans-serif;">
    {{-- DASHBOARD --}}
    <x-navbar></x-navbar>
    {{ $slot }}
    </div>
</body>

</html>
