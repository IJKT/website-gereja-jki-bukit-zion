<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                <div>
                    <label class="block font-semibold mb-1">ID PELAYAN</label>
                    <input type="text" value="{{ $pelayan['id_pelayan'] }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">USERNAME</label>
                    <input type="text" value="{{ $pelayan->jemaat->username }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>

                <div>
                    <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                    <input type="text" value="{{ $pelayan->jemaat->nama_jemaat }}"
                        class="w-full p-2 rounded bg-gray-100" disabled>
                </div>
            </div>

            <div x-data="{ hak_akses: '{{ $pelayan['hak_akses_pelayan'] }}' }">
                <label class="block font-semibold my-1">HAK AKSES</label>
                <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Administrator'" :checked="hak_akses === 'Administrator'">
                        <span
                            :class="hak_akses == 'Administrator' ? 'font-semibold' : 'font-normal'">Administrator</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses"class="form-radio text-[#215773]"
                            @click="hak_akses = 'Multimedia'" :checked="hak_akses === 'Multimedia'">
                        <span :class="hak_akses == 'Multimedia' ? 'font-semibold' : 'font-normal'">Multimedia</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Koordinator'" :checked="hak_akses === 'Koordinator'">
                        <span :class="hak_akses == 'Koordinator' ? 'font-semibold' : 'font-normal'">Koordinator</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Praise & Worship'" :checked="hak_akses === 'Praise & Worship'">
                        <span :class="hak_akses == 'Praise & Worship' ? 'font-semibold' : 'font-normal'">Praise &
                            Worship</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Bendahara'" :checked="hak_akses === 'Bendahara'">
                        <span :class="hak_akses == 'Bendahara' ? 'font-semibold' : 'font-normal'">Bendahara</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Pelayan Gereja'" :checked="hak_akses === 'Pelayan Gereja'">
                        <span :class="hak_akses == 'Pelayan Gereja' ? 'font-semibold' : 'font-normal'">Pelayan
                            Gereja</span>
                    </label>
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
            <a href="/manajemen/pelayan">
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
