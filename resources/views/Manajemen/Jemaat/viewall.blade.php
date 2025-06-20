<!-- TODO: buat print biar bisa mencetak setiap list jemaat-->
<!-- TODO: buat biar admin bisa mengatur baptis atau pernikahan kalau user adalah orang yang cukup berumur-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">MANAJEMEN JEMAAT</label>

                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <form method="GET" action="{{ route('Manajemen.Jemaat.viewall') }}">
                            <div class="mx-2 mt-2 mb-4">
                                <label for="hak_akses_jemaat" class="block text-sm font-medium text-gray-700">Jenis
                                    Pembukuan</label>
                                <select name="hak_akses_jemaat" id="hak_akses_jemaat"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Semua</option>
                                    <option value="Jemaat">Jemaat</option>
                                    <option value="Pelayan">Pelayan</option>
                                </select>
                            </div>
                    </x-filter-dropdown>
                </div>
                <table class="w-full border-collapse ">
                    <thead>
                        <tr class="bg-white text-sm font-semibold">
                            <th class="border border-gray-300 px-4 py-2">NAMA LENGKAP</th>
                            <th class="border border-gray-300 px-4 py-2">HAK AKSES</th>
                            <th class="border border-gray-300 px-4 py-2">NIK</th>
                            <th class="border border-gray-300 px-4 py-2">STATUS</th>
                            <th class="border border-gray-300 px-4 py-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jemaat as $_jemaat)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2 text-left">
                                    {{ $_jemaat['nama_jemaat'] }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $_jemaat['hak_akses_jemaat'] }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $_jemaat['nik_jemaat'] }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="font-semibold">
                                        @if ($_jemaat['status_jemaat'] == 1)
                                            AKTIF
                                        @else
                                            <div class="text-red-500"> NONAKTIF </div>
                                        @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('Manajemen.Jemaat.ubah', $_jemaat) }}">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-2">
                    <div>
                        {{ $jemaat->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="{{ route('Manajemen.Jemaat.Pengajuan.viewall') }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    LIHAT PENGAJUAN
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
