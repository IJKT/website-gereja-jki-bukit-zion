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
        <img src="{{ asset('pics/Background.png') }}" class="fixed inset-0 w-full h-full object-cover filter blur-xs"
            style="z-index: -1;">

        {{-- Forgot Password form --}}
        <div class="h-screen w-6/11 bg-[#D9D9D9] shadow-md rounded-r-lg p-12 flex flex-col justify-center">
            <div class="items-center justify-center">
                <img src="{{ asset('pics/logo_pic.png') }}" class="w-[70px] h-[70px] mx-auto">
                <h1 class="text-3xl font-extrabold text-center mb-5">RESET PASSWORD</h1>
            </div>
            <form method="POST" action="{{ route('reset_password_auth') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <label>Email</label>
                <input type="email" name="email" required
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]"
                    autocomplete="off" placeholder="Masukkan Email Anda" />

                <label>Password Baru</label>
                <input type="password" name="password" required placeholder="Masukkan Password Baru Anda"
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]" />

                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Konfirmasi Password Baru Anda"
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]" />

                <div class="flex items-center justify-center">
                    <button type="submit"
                        class="w-1/5 p-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">RESET</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
