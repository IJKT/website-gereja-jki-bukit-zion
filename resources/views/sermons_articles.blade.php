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
                    <button class="bg-[#215773] text-white px-2 py-2 rounded hover:bg-[#1a4a60]">
                        <!-- Replace with icon if needed -->
                        <svg class="h-5 w-5 font-bold" viewBox="0 0 15 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 2.5H15M3 7.5H12M5 12.5H10" stroke="#ffffff" />
                        </svg>
                    </button>
                </div>
                <table class="w-full border-collapse ">
                    <thead>
                        <tr class="bg-white text-sm font-semibold">
                            <th class="border border-gray-300 px-4 py-2">ID RANGKUMAN</th>
                            <th class="border border-gray-300 px-4 py-2">JUDUL</th>
                            <th class="border border-gray-300 px-4 py-2">TIPE RANGKUMAN</th>
                            <th class="border border-gray-300 px-4 py-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rangkuman as $_rangkuman)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $_rangkuman['id'] }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-left">
                                    {{ $_rangkuman['judul'] }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $_rangkuman['tipe'] }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <button
                                        class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                TAMBAH
            </button>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
