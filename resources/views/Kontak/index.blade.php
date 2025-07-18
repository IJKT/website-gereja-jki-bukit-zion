<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">KONTAK</label>

                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <form method="GET" action="{{ route('Kontak.index') }}">
                            <div class="mx-2 mt-2 mb-4">
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="kategori" id="kategori"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Semua</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Baptisan">Baptisan</option>
                                    <option value="Pernikahan">Pernikahan</option>
                                    <option value="Persembahan">Persembahan</option>
                                </select>
                            </div>
                    </x-filter-dropdown>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-white text-sm font-semibold">
                                <th class="border border-gray-300 px-4 py-2">NAMA</th>
                                <th class="border border-gray-300 px-4 py-2">KATEGORI</th>
                                <th class="border border-gray-300 px-4 py-2">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kontak as $item)
                                {{-- @dd($_jadwal->jenis_ibadah) --}}
                                <tr class="bg-white text-sm text-center">
                                    <td class="border border-gray-300 px-4 py-2 text-left">
                                        {{ $item->nama }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-left">
                                        {{ $item->kategori }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('Kontak.balas', $item->id_kontak) }}">
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
                        {{ $kontak->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</x-layout_sistem_informasi>
