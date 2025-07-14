<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">JADWAL</label>

                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <form method="GET" action="{{ route('Jadwal.viewall') }}">
                            <div class="mx-2 mt-2 mb-4">
                                <label for="tanggal_awal" class="block text-sm font-medium text-gray-700">Tanggal
                                    Awal</label>
                                <input type="date" id="tanggal_awal" name="tanggal_awal"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    value="{{ request('tanggal_awal') }}"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Tanggal
                                    Akhir</label>
                                <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    min="{{ request('tanggal_awal') }}" value="{{ request('tanggal_akhir') }}"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <label for="jenis_ibadah" class="block text-sm font-medium text-gray-700">Jenis
                                    Ibadah</label>
                                <select name="jenis_ibadah" id="jenis_ibadah"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Semua</option>
                                    <option value="Sunday Service">Sunday Service</option>
                                    <option value="Sunday School">Sunday School</option>
                                    <option value="Shabbat Fellowship">Shabbat Fellowship</option>
                                    <option value="Shabbat Service">Shabbat Service</option>
                                </select>
                            </div>
                    </x-filter-dropdown>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-white text-sm font-semibold">
                                <th class="border border-gray-300 px-4 py-2">TIPE IBADAH</th>
                                <th class="border border-gray-300 px-4 py-2">TANGGAL IBADAH</th>
                                <th class="border border-gray-300 px-4 py-2">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal as $_jadwal)
                                {{-- @dd($_jadwal->jenis_ibadah) --}}
                                <tr class="bg-white text-sm text-center">
                                    <td class="border border-gray-300 px-4 py-2 text-left">
                                        {{ $_jadwal->jenis_ibadah }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ \Carbon\Carbon::parse($_jadwal->tgl_ibadah)->isoFormat(' dddd, DD MMMM Y HH:mm') }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('Jadwal.ubah', $_jadwal->id_jadwal) }}">
                                            <button
                                                class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Praise & Worship' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Multimedia')
                <a href="{{ route('Jadwal.tambah') }}">
                    <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                        TAMBAH
                    </button>
                </a>
            @endif
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
