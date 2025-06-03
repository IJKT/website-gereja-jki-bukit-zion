<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body style="font-family: 'Kantumruy Pro', sans-serif;">
    <div>
        {{-- BG IMG --}}
        <img src="pics/background.png" class="fixed inset-0 w-full h-full object-cover filter blur-xs"
            style="z-index: -1;">

        {{-- register form --}}
        <div class="h-screen w-6/11 bg-[#D9D9D9] shadow-md rounded-r-lg p-12 flex flex-col justify-center">
            <div class="items-center justify-center">
                <img src="pics/logo_pic.png" class="w-[70px] h-[70px] mx-auto">
                <h1 class="text-3xl font-extrabold text-center mb-5">DAFTAR AKUN</h1>
            </div>
            <form x-data="{
                username: '',
                usernameError: false,
                password: '',
                konfirmasi_password: '',
                async cekUsername() {
                    const res = await fetch('{{ route('Home.cek.username') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ username: this.username })
                    });
                    const data = await res.json();
                    this.usernameError = data.exists;
                },
                async handleSubmit(e) {
                    if (this.password !== this.konfirmasi_password) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Password dan konfirmasi password harus sama!'
                        });
                        return;
                    }
                    if (this.usernameError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Username sudah digunakan!'
                        });
                        return;
                    }
            
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Akun berhasil terregistrasi',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        e.target.submit();
                    });
                }
            }" @submit.prevent="handleSubmit($event)"
                action="{{ route('Home.Akun.register_authenticate') }}" method="post" class="flex flex-col gap-4 mt-8">
                @csrf
                <div class="flex justify-between gap-4">
                    {{-- left side --}}
                    <div class="flex flex-col w-1/2 space-y-2">
                        <label for="username" class="font-semibold mb-1">Username</label>
                        <input type="text" name="username" id="username" placeholder="Masukkan Username Anda"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                            autocomplete="off" required pattern="^\S+$" x-model="username"
                            @input.debounce.500ms="cekUsername()" :class="usernameError ? 'border-red-500' : ''"
                            oninvalid="this.setCustomValidity('Username tidak boleh kosong atau mengandung spasi')"
                            oninput="this.setCustomValidity(''); this.value = this.value.replace(/\s/g, '')">
                        <span x-show="usernameError" class="text-red-600 text-sm mt-1">Username sudah digunakan</span>

                        <label for="password" class="font-semibold mb-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan Password Anda"
                            x-model="password"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                            autocomplete="off" required minlength="8"
                            oninvalid="this.setCustomValidity('Password belum diisi atau kurang dari 8 karakter')"
                            oninput="this.setCustomValidity('')">

                        <label for="nama_lengkap" class="font-semibold mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                            placeholder="masukkan Nama Lengkap Anda"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                            autocomplete="off" required oninvalid="this.setCustomValidity('Nama lengkap belum diisi')"
                            oninput="this.setCustomValidity('')">

                        <label for="nik" class="font-semibold mb-1">NIK</label>
                        <input type="text" name="nik" id="nik" placeholder="Masukkan NIK anda"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                            autocomplete="off" required pattern="[0-9]{16}"
                            oninvalid="this.setCustomValidity('NIK harus terdiri dari 16 angka')"
                            oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '')">

                        <div>
                            <label class="font-semibold mb-2 block">Tempat & Tanggal Lahir</label>
                            <div class="flex justify-between gap-[10px]">
                                <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Kota lahir"
                                    class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]"
                                    autocomplete="off">
                                <input type="date" name="tgl_lahir" id="tgl_lahir"
                                    class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]"
                                    max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    {{-- right side --}}
                    <div class="flex flex-col w-1/2 space-y-2">
                        <label for="email" class="font-semibold mb-1">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan email anda"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            autocomplete="off" oninvalid="this.setCustomValidity('Email belum diisi')"
                            oninput="this.setCustomValidity('')">

                        <label for="konfirmasi_password" class="font-semibold mb-1">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                            x-model="konfirmasi_password" placeholder="Konfirmasi password anda"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Konfirmasi password belum diisi')"
                            oninput="this.setCustomValidity('')">

                        <label for="alamat" class="font-semibold mb-1">Alamat</label>
                        <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat anda"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            autocomplete="off" oninvalid="this.setCustomValidity('Alamat belum diisi')"
                            oninput="this.setCustomValidity('')">
                        {{-- onchange="if(!this.value) {window.open('www.google.com/maps', '_blank');}"> --}}

                        <label for="telepon" class="font-semibold mb-1">Telepon</label>
                        <input type="tel" name="telepon" id="telepon"
                            placeholder="Masukkan nomor telepon anda"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            autocomplete="off" pattern="[0-9]+" minlength="8"
                            oninvalid="this.setCustomValidity('Nomor telepon hanya boleh angka dan tidak boleh kosong')"
                            oninput="this.setCustomValidity('')">

                        <div class="mb-4" x-data="{ gender: '' }">
                            <label class="font-semibold block mb-4">Jenis Kelamin</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="gender" @click="gender = 'Pria'"
                                        @click=class="form-radio text-[#215773]" value="P">
                                    <span :class="gender == 'Pria' ? 'font-semibold' : 'font-normal'">Pria</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="gender" @click="gender = 'Wanita'"
                                        class="form-radio text-[#215773]" value="W">
                                    <span :class="gender == 'Wanita' ? 'font-semibold' : 'font-normal'">Wanita</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center">
                    <button type="submit"
                        class="w-1/5 p-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">REGISTER</button>
                </div>
            </form>
            {{-- <button type="submit"
                class="w-1/5 p-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold"
                onclick="window.location.href='{{ route('Home.Akun.login') }}'">REGISTER</button> --}}
        </div>
    </div>
</body>

</html>
