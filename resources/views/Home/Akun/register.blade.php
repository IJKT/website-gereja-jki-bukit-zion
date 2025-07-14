<x-layout_autentikasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- FORM --}}
    <div class="register-form bg-[#D9D9D9] shadow-md rounded-lg p-12 flex flex-col justify-center">
        <div class="items-center justify-center">
            <img src="pics/logo_pic.png" class="w-[70px] h-[70px] mx-auto">
            <h1 class="text-3xl font-extrabold text-center mb-5">REGISTRASI AKUN</h1>
        </div>

        <form x-data="registerForm" @submit.prevent="handleSubmit($event)"
            action="{{ route('Home.Akun.register_authenticate') }}" method="POST" class="flex flex-col gap-4 mt-8">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <div class="flex flex-col w-full space-y-2">
                    <label for="username" class="font-semibold mb-1">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan Username Anda"
                        tabindex="1" class="p-2 rounded-md border-2 bg-white focus:border-[#215773]"
                        autocomplete="off" required pattern="^\S+$" x-model="username"
                        @input.debounce.500ms="cekUsername" :class="usernameError ? 'border-red-500' : 'border-white'"
                        oninvalid="this.setCustomValidity('Username tidak boleh kosong atau mengandung spasi')"
                        oninput="this.setCustomValidity(''); this.value = this.value.replace(/\s/g, '')">
                    <span x-show="usernameError" class="text-red-600 text-sm mt-1">Username sudah digunakan</span>
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label for="email" class="font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan Email Anda" tabindex="2"
                        class="p-2 rounded-md border-2 bg-white focus:border-[#215773]" autocomplete="off" required
                        x-model="email" @input.debounce.500ms="cekEmail"
                        :class="emailError ? 'border-red-500' : 'border-white'"
                        oninvalid="this.setCustomValidity('Email belum diisi')" oninput="this.setCustomValidity('')">
                    <span x-show="emailError" class="text-red-600 text-sm mt-1">Email sudah digunakan</span>
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label for="password" class="font-semibold mb-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan Password Anda"
                        tabindex="3" class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                        autocomplete="off" required minlength="8" x-model="password"
                        oninvalid="this.setCustomValidity('Password belum diisi atau kurang dari 8 karakter')"
                        oninput="this.setCustomValidity('')">
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label for="konfirmasi_password" class="font-semibold mb-1">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" tabindex="4"
                        placeholder="Konfirmasi password anda"
                        class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                        x-model="konfirmasi_password"
                        oninvalid="this.setCustomValidity('Konfirmasi password belum diisi')"
                        oninput="this.setCustomValidity('')">
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label for="nama_lengkap" class="font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan Nama Lengkap Anda"
                        tabindex="5" class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                        autocomplete="off" required oninvalid="this.setCustomValidity('Nama lengkap belum diisi')"
                        oninput="this.setCustomValidity('')">
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label for="alamat" class="font-semibold mb-1">Alamat</label>
                    <input type="text" name="alamat" id="alamat" placeholder="Masukkan Alamat Anda"
                        tabindex="6" class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                        required autocomplete="off" oninvalid="this.setCustomValidity('Alamat belum diisi')"
                        oninput="this.setCustomValidity('')">
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label for="nik" class="font-semibold mb-1">NIK</label>
                    <input type="text" name="nik" id="nik" placeholder="Masukkan NIK Anda" tabindex="7"
                        class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                        autocomplete="off" required pattern="[0-9]{16}"
                        oninvalid="this.setCustomValidity('NIK harus terdiri dari 16 angka')"
                        oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '')">

                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label for="telepon" class="font-semibold mb-1">Telepon</label>
                    <input type="text" name="telepon" id="telepon" placeholder="Masukkan Nomor Telepon Anda"
                        tabindex="8" class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]"
                        required autocomplete="off" minlength="8" pattern="\d*" inputmode="numeric"
                        oninvalid="this.setCustomValidity('Nomor telepon tidak boleh kosong')"
                        oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <label class="font-semibold mb-2 block">Tempat & Tanggal Lahir</label>
                    <div class="flex justify-between gap-[10px]">
                        <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Kota lahir"
                            tabindex="9"
                            class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]"
                            autocomplete="off">
                        <input type="date" name="tgl_lahir" id="tgl_lahir" tabindex="10"
                            class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]"
                            max="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="flex flex-col w-full space-y-2">
                    <div class="mb-4" x-data="{ gender: '' }">
                        <label class="font-semibold block mb-4">Jenis Kelamin</label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="gender" @click="gender = 'Pria'" value="P"
                                    tabindex="11">
                                <span :class="gender == 'Pria' ? 'font-semibold' : 'font-normal'">Pria</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="gender" @click="gender = 'Wanita'" value="W"
                                    tabindex="12">
                                <span :class="gender == 'Wanita' ? 'font-semibold' : 'font-normal'">Wanita</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('login') }}" class="text-sm font-bold underline hover:text-[#215773]">Kembali ke
                halaman login</a>
            <div class="flex items-center justify-center">
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">REGISTRASI</button>
            </div>
        </form>
    </div>
    </div>

    {{-- ALPINE SCRIPT --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerForm', () => ({
                username: '',
                email: '',
                password: '',
                konfirmasi_password: '',
                usernameError: false,
                emailError: false,

                cekUsername() {
                    fetch('{{ route('Home.cek_username') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                username: this.username
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.usernameError = data.exists;
                        });
                },

                cekEmail() {
                    fetch('{{ route('Home.cek_email') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                email: this.email
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.emailError = data.exists;
                        });
                },

                handleSubmit(e) {
                    if (this.password !== this.konfirmasi_password) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Password dan konfirmasi harus sama!'
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

                    if (this.emailError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Email sudah terdaftar!'
                        });
                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Akun berhasil terdaftar',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        e.target.submit();
                    });
                }
            }));
        });
    </script>
</x-layout_autentikasi>
