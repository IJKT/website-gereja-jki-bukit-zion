<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">SERMONS & ARTICLES</label>

                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <form method="GET" action="{{ route('RangkumanFirman.viewall') }}">
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
                                <label for="tipe_rangkuman" class="block text-sm font-medium text-gray-700">Tipe
                                    Rangkuman</label>
                                <select name="tipe_rangkuman" id="tipe_rangkuman"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Semua</option>
                                    <option value="Sermons">Sermons</option>
                                    <option value="Articles">Articles</option>
                                    <option value="Devotions">Devotions</option>
                                </select>
                            </div>
                    </x-filter-dropdown>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-white text-sm font-semibold">
                                <th class="border border-gray-300 px-4 py-2">TANGGAL PEMBUATAN</th>
                                <th class="border border-gray-300 px-4 py-2">JUDUL</th>
                                <th class="border border-gray-300 px-4 py-2">TIPE</th>
                                <th class="border border-gray-300 px-4 py-2">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rangkuman as $_rangkuman)
                                <tr class="bg-white text-sm text-center">
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ \Carbon\Carbon::parse($_rangkuman->tgl_rangkuman)->locale('id_ID')->isoFormat('DD MMMM Y') }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-left">
                                        {{ $_rangkuman->judul_rangkuman }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $_rangkuman->tipe_rangkuman }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('RangkumanFirman.ubah', $_rangkuman) }}">
                                            <button
                                                class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-2">
                    <div>
                        {{ $rangkuman->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="{{ route('RangkumanFirman.tambah') }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    TAMBAH
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
