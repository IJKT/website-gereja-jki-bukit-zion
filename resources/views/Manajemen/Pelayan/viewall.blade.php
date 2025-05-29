<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">MANAJEMEN PELAYAN</label>

                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <div>
                            <label for="cari" class="block text-sm font-medium text-gray-700">Cari Nama</label>
                            <input type="text" name="cari" id="cari"
                                class="pl-2 bg-white mt-1 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Masukkan Nama Pelayan">
                        </div>
                        <div>
                            <label for="hak-akses" class="block text-sm font-medium text-gray-700">Hak Akses</label>
                            <select name="status" id="status"
                                class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Semua</option>
                                <option value="Administrator">Administrator</option>
                                <option value="Koordinator">Koordinator</option>
                                <option value="Bendahara">Bendahara</option>
                                <option value="Multimedia">Multimedia</option>
                                <option value="Praise & Worship">Praise & Worship</option>
                                <option value="Pelayan Gereja">Pelayan Gereja</option>
                            </select>
                        </div>
                    </x-filter-dropdown>
                </div>
                <table class="w-full border-collapse ">
                    <thead>
                        <tr class="bg-white text-sm font-semibold">
                            {{-- <th class="border border-gray-300 px-4 py-2">USERNAME</th> --}}
                            <th class="border border-gray-300 px-4 py-2">NAMA LENGKAP</th>
                            <th class="border border-gray-300 px-4 py-2">HAK AKSES</th>
                            <th class="border border-gray-300 px-4 py-2">STATUS</th>
                            <th class="border border-gray-300 px-4 py-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelayan as $_pelayan)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2 text-left">
                                    {{ $_pelayan->jemaat->nama_jemaat }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $_pelayan['hak_akses_pelayan'] }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="font-semibold">
                                        @if ($_pelayan['status_pelayan'] == 1)
                                            AKTIF
                                        @else
                                            <div class="text-red-500"> NONAKTIF </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="/manajemen/pelayan/{{ $_pelayan['id_pelayan'] }}">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">UBAH</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- minta tolong pak david aja, ini cara ganti warna pagination sama ganti kata2 "Showing 1 to 5 of 6 results"nya" gimana --}}
                <div class="mt-2">
                    {{ $pelayan->links() }}
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="/manajemen/pelayan/tambah">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    TAMBAH
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
