<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                <div>
                    <label class="block font-semibold mb-1">NAMA</label>
                    <input type="text" value="{{ $nama_lengkap }}" class="w-full p-2 rounded bg-white" disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">ALAMAT EMAIL</label>
                    <input type="text" value="{{ $email }}" class="w-full p-2 rounded bg-white" disabled>
                </div>

                <div>
                    <label class="block font-semibold mb-1">NIK</label>
                    <input type="text" value="{{ $nik }}" class="w-full p-2 rounded bg-white" disabled>
                </div>

                <div>
                    <label class="block font-semibold mb-1">TEMPAT & TGL LAHIR</label>
                    <div class="flex justify-between gap-2">
                        <input type="text" value="{{ $tempat_lahir }}" class="w-full p-2 rounded bg-white" disabled>
                        <input type="text"
                            value="{{ \Carbon\Carbon::parse($tanggal_lahir)->locale('id_ID')->isoFormat('DD MMMM Y') }}"
                            class="w-full p-2 rounded bg-white" disabled>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">ALAMAT</label>
                    <input type="text" value="{{ $alamat }}" class="w-full p-2 rounded bg-white" disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">JENIS KELAMIN</label>
                    <input type="text"
                        value=
                        "@if ($jenis_kelamin == 'P') Pria
                        @elseif ($jenis_kelamin == 'W') Wanita @endif"
                        class="w-full p-2 rounded bg-white" disabled>
                </div>

                <div>
                    <label class="block font-semibold mb-1">NOMOR HP</label>
                    <input type="text" value="{{ $nomor_hp }}" class="w-full p-2 rounded bg-white" disabled>
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">UBAH
            </button>
        </div>
    </div>
</x-layout_sistem_informasi>
