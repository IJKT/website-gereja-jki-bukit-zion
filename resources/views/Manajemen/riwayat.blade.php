<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">MANAJEMEN RIWAYAT</label>
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
                            <th class="border border-gray-300 px-4 py-2">TANGGAL RIWAYAT</th>
                            <th class="border border-gray-300 px-4 py-2">NAMA PELAYAN</th>
                            <th class="border border-gray-300 px-4 py-2">NAMA TABEL YANG DIUBAH</th>
                            <th class="border border-gray-300 px-4 py-2">JENIS RIWAYAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $_riwayat)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ \Carbon\Carbon::parse($_riwayat['tgl_perubahan'])->locale('id_ID')->isoFormat('DD MMMM Y HH:mm:ss') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-left">
                                    {{ $_riwayat->pelayan->jemaat->nama_jemaat }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{-- @dd($_riwayat->id_tabel_ubah) --}}
                                    @if (substr($_riwayat->id_tabel_ubah, 0, 2) == 'LI')
                                        LAGU
                                    @elseif (substr($_riwayat['id_tabel_ubah'], 0, 2) == 'PG')
                                        PEMBUKUAN
                                    @elseif (substr($_riwayat['id_tabel_ubah'], 0, 2) == 'JI')
                                        JADWAL
                                    @elseif (substr($_riwayat['id_tabel_ubah'], 0, 2) == 'RF')
                                        RANGKUMAN
                                    @elseif (substr($_riwayat['id_tabel_ubah'], 0, 2) == 'PL')
                                        PELAYAN
                                        {{-- 
                                        TODO: tambahin fitur log yang lain
                                        --}}
                                    @endif
                                    - ({{ $_riwayat['id_tabel_ubah'] }})
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($_riwayat['jenis_perubahan'] == 1)
                                        Tambah
                                    @elseif ($_riwayat['jenis_perubahan'] == 2)
                                        Ubah
                                    @elseif ($_riwayat['jenis_perubahan'] == 3)
                                        Hapus
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">
                    <div>
                        {{ $riwayat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
