<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                <div>
                    <label class="block font-semibold mb-1">ID JEMAAT</label>
                    <input type="text" value="{{ $jemaat->id_jemaat }}" class="w-full p-2 rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">USERNAME</label>
                    <input type="text" value="{{ $jemaat->username }}" class="w-full p-2 rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                    <input type="text" value="{{ $jemaat->nama_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">EMAIL</label>
                    <input type="text" value="{{ $jemaat->email_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">NIK</label>
                    <input type="text" value="{{ $jemaat->nik_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">ALAMAT</label>
                    <input type="text" value="{{ $jemaat->alamat_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR</label>
                    <div class="grid grid-cols-2 gap-x-5">
                        <input type="text" value="{{ $jemaat->tmpt_lahir_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                        <input type="text"
                            value="{{ \Carbon\Carbon::parse($jemaat->id_baptis_jemaat)->locale('id_ID')->isoFormat('DD MMMM Y') }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold mb-1">NOMOR TELEPON</label>
                    <input type="text" value="{{ $jemaat->telp_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>
                {{-- 
                TODO:perbaiki baptis sama pernikahan kalau udah ada di database 
                --}}
                <div>
                    <label class="block font-semibold mb-1">TANGGAL BAPTIS</label>
                    <input type="text" value="{{ $jemaat->id_baptis_jemaat }}"
                        class="w-full p-2 rounded bg-gray-100" placeholder="Data Baptis Belum Ditemukan" disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">NAMA PASANGAN</label>
                    <input type="text" value="{{ $jemaat->id_pasangan_jemaat }}"
                        class="w-full p-2 rounded bg-gray-100" placeholder="Data Pernikahan Belum Ditemukan" disabled>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-x-10">
                <div x-data="{ hak_akses: '{{ $jemaat['hak_akses_jemaat'] }}' }">
                    <label class="block font-semibold my-1">HAK AKSES</label>
                    <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                                @click="hak_akses = 'Jemaat'" :checked="hak_akses === 'Jemaat'">
                            <span :class="hak_akses == 'Jemaat' ? 'font-semibold' : 'font-normal'">Jemaat</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak-akses"class="form-radio text-[#215773]"
                                @click="hak_akses = 'Pelayan'" :checked="hak_akses === 'Pelayan'">
                            <span :class="hak_akses == 'Pelayan' ? 'font-semibold' : 'font-normal'">Pelayan</span>
                        </label>
                    </div>
                </div>
                <div x-data="{ jenis_kelamin: '{{ $jemaat['jk_jemaat'] }}' }">
                    <label class="block font-semibold my-1">JENIS KELAMIN</label>
                    <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis-kelamin" class="form-radio text-[#215773]"
                                @click="jenis_kelamin = 'P'" :checked="jenis_kelamin === 'P'">
                            <span :class="jenis_kelamin == 'P' ? 'font-semibold' : 'font-normal'">Pria</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis-kelamin" class="form-radio text-[#215773]"
                                @click="jenis_kelamin = 'W'" :checked="jenis_kelamin === 'W'">
                            <span :class="jenis_kelaminx == 'W' ? 'font-semibold' : 'font-normal'">Wanita</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="#">
                <button class="bg-red-500  px-6 py-2 rounded-md hover:bg-red-700">
                    NONAKTIF
                </button>
            </a>
            <a href="/manajemen/jemaat">
                <button class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
            <a href="#">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    SIMPAN
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
