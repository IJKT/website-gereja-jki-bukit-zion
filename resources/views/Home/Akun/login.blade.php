<x-layout_autentikasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Login form --}}
    <div class="login-form w-[40%] bg-[#D9D9D9] shadow-md rounded-lg p-12 flex flex-col justify-center">
        <div class="items-center justify-center">
            <img src="{{ asset('pics/logo_pic.png') }}" class="w-[70px] h-[70px] mx-auto">
            <h1 class="text-3xl font-extrabold text-center mb-5">MASUK KE AKUN</h1>
        </div>
        <form action="{{ route('login_authenticate') }}" method="post" class="flex flex-col gap-4 mt-8">
            @csrf
            <div>
                <label for="username" class="font-semibold">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan Username Anda"
                    value="{{ old('username') }}"
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]"
                    autocomplete="off" required oninvalid="this.setCustomValidity('Username is required')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div>
                <label for="password" class="font-semibold">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password Anda"
                    class="w-full mt-2 p-2 rounded-md border-2 border-[#ffffff] bg-[#ffffff] focus:border-[#215773]"
                    required oninvalid="this.setCustomValidity('Password is required')"
                    oninput="this.setCustomValidity('')">
            </div>
            @if (session('gagal'))
                <p class="text-center text-md">{{ session('gagal') }}</p>
            @endif
            <a href="{{ route('forgot_password') }}" class="text-sm font-bold underline hover:text-[#215773]">Lupa
                Password?</a>
            <a href="{{ route('Home.Akun.register') }}" class="text-sm font-bold underline hover:text-[#215773]">Belum
                punya akun?
                Daftar disini</a>
            <div class="flex items-center justify-center">
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">
                    MASUK
                </button>
            </div>
        </form>

    </div>
    </div>
</x-layout_autentikasi>
