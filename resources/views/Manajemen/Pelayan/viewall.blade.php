<!-- TODO: buat print biar bisa mencetak setiap list pelayan-->

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
                        <form method="GET" action="{{ route('Manajemen.Pelayan.viewall') }}">
                            <div class="mx-2 mt-2 mb-4">
                                <label for="hak-akses" class="block text-sm font-medium text-gray-700">Hak
                                    Akses</label>
                                <select name="hak_akses" id="hak_akses"
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
                                    <a href="{{ route('Manajemen.Pelayan.ubah', $_pelayan) }}">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
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
            <a href="{{ route('Manajemen.Pelayan.unduh', request()->query()) }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    UNDUH
                </button>
            </a>
            <a href="{{ route('Manajemen.Pelayan.tambah') }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    TAMBAH
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
