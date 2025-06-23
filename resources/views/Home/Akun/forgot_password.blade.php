<x-layout_autentikasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Forgot Password form --}}
    <div class="login-form w-[40%] bg-[#D9D9D9] shadow-md rounded-lg p-12 flex flex-col justify-center">
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
                    class="px-4 py-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">KIRIM
                    LINK</button>
            </div>
        </form>
    </div>
    </div>
</x-layout_autentikasi>
