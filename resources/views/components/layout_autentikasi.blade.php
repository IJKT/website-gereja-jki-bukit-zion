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
    <style>
        @media (max-width: 768px) {
            .login-form {
                width: 100vw;
                height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                background-color: #D9D9D9;
                z-index: 1;
                overflow: scroll;
            }
        }
    </style>
</head>

<body style="font-family: 'Kantumruy Pro', sans-serif;">
    <div class="flex justify-center items-center h-screen">
        {{-- BG IMG --}}
        <img src="{{ asset('pics/Background.png') }}" class="fixed inset-0 w-full h-full object-cover filter blur-xs"
            style="z-index: -1;">

        {{ $slot }}


</body>

</html>
