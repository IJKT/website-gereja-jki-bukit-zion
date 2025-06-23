<x-layout_autentikasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Forgot Password form --}}
    <div class="login-form w-[40%] bg-[#D9D9D9] shadow-md rounded-lg p-12 flex flex-col justify-center">
        <div class="items-center justify-center">
            <img src="{{ asset('pics/logo_pic.png') }}" class="w-[70px] h-[70px] mx-auto">
            <h1 class="text-3xl font-extrabold text-center mb-5">RESET PASSWORD</h1>
        </div>
        <form method="POST" action="{{ route('reset_password_auth') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label class="font-semibold">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]"
                    autocomplete="off" placeholder="Masukkan Email Anda" />
            </div>

            <div class="mt-2">
                <label class="font-semibold">Password Baru</label>
                <input type="password" name="password" required placeholder="Masukkan Password Baru Anda"
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]" />
            </div>

            <div class="mt-2">
                <label class="font-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Konfirmasi Password Baru Anda"
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]" />
            </div>

            <div class="flex items-center justify-center">
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">RESET</button>
            </div>
        </form>
    </div>
    </div>
</x-layout_autentikasi>
