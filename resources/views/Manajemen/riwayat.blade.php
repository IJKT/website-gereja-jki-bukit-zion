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

                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <form method="GET" action="{{ route('Manajemen.Riwayat') }}">
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
                                <label for="jenis_riwayat" class="block text-sm font-medium text-gray-700">Jenis
                                    riwayat</label>
                                <select name="jenis_riwayat" id="jenis_riwayat"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Semua</option>
                                    <option value="1">Tambah</option>
                                    <option value="2">Ubah</option>
                                    <option value="3">Hapus</option>
                                </select>
                            </div>
                    </x-filter-dropdown>
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
                                    {{ \Carbon\Carbon::parse($_riwayat->tgl_perubahan)->isoFormat(' dddd, DD MMMM Y HH:mm:ss') }}
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
                                    @elseif (substr($_riwayat['id_tabel_ubah'], 0, 2) == 'JM')
                                        JEMAAT
                                    @elseif (substr($_riwayat['id_tabel_ubah'], 0, 2) == 'PJ')
                                        PENGAJUAN JEMAAT
                                    @endif
                                    - ({{ $_riwayat['id_tabel_ubah'] }})
                                </td>
                                <td class="border border-gray-300 px-4 py-2 font-semibold">
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
