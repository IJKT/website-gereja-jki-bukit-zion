<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">

            <!-- Marriage Info -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">TANGGAL BAPTIS</label>
                <input type="text" placeholder="Kirimkan Pengajuan Terlebih Dahulu"
                    class="w-full p-2 rounded bg-white border border-gray-300" disabled>
            </div>

            <!-- Submission Table -->
            <div>
                <label class="block font-semibold mb-2">PENGAJUAN SAYA</label>
                <table class="w-full border-collapse ">
                    <thead>
                        <tr class="bg-white text-sm font-semibold">
                            <th class="border border-gray-300 px-4 py-2">TANGGAL PENGAJUAN</th>
                            <th class="border border-gray-300 px-4 py-2">STATUS</th>
                            <th class="border border-gray-300 px-4 py-2">KOMENTAR</th>
                            <th class="border border-gray-300 px-4 py-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Add dynamic rows here -->
                        <tr class="bg-white text-sm text-center">
                            <td class="border border-gray-300 px-4 py-2">none</td>
                            <td class="border border-gray-300 px-4 py-2">none</td>
                            <td class="border border-gray-300 px-4 py-2">none</td>
                            <td class="border border-gray-300 px-4 py-2">none</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                TAMBAH PENGAJUAN
            </button>
        </div>
    </div>
</x-layout_sistem_informasi>
