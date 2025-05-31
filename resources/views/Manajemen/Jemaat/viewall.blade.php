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
                    <button class="bg-[#215773] text-white px-2 py-2 rounded hover:bg-[#1a4a60]">
                        <!-- Replace with icon if needed -->
                        <svg class="h-5 w-5 font-bold" viewBox="0 0 15 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 2.5H15M3 7.5H12M5 12.5H10" stroke="#ffffff" />
                        </svg>
                        <i class='bx  bx-angle'></i>
                    </button>
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
                                    <a href="/manajemen/jemaat/{{ $_jemaat['id_jemaat'] }}">
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
            <a href="/manajemen/pengajuan">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    LIHAT PENGAJUAN
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
