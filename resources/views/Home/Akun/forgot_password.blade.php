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
</head>

<body style="font-family: 'Kantumruy Pro', sans-serif;">
    <div>
        {{-- BG IMG --}}
        <img src="pics/background.png" class="fixed inset-0 w-full h-full object-cover filter blur-xs"
            style="z-index: -1;">

        {{-- Forgot Password form --}}
        <div class="h-screen w-6/11 bg-[#D9D9D9] shadow-md rounded-r-lg p-12 flex flex-col justify-center">
            <div class="items-center justify-center">
                <img src="pics/logo_pic.png" class="w-[70px] h-[70px] mx-auto">
                <h1 class="text-3xl font-extrabold text-center mb-5">LUPA PASSWORD</h1>
            </div>
            <form method="POST" action="{{ route('forgot_password_auth') }}" class="flex flex-col gap-4 mt-8">
                @csrf
                <label class="font-semibold">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]"
                    autocomplete="off" placeholder="Masukkan Email Anda" />
                @if (session('status'))
                    <div class="text-green-600 mb-4">{{ session('status') }}</div>
                @endif
                <div class="flex items-center justify-center">
                    <button type="submit"
                        class="w-1/5 p-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">KIRIM
                        LINK</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
