<!-- TODO: apakah harus ada checkbox buat "SUDAH BAPTIS" dan "BELUM BAPTIS"?-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}

    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Marriage Info -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">TANGGAL PERNIKAHAN</label>
                <input type="text" placeholder="Tanggal Pernikahan Tidak Ditemukan"
                    value="@if ($data_pernikahan != null) {{ \Carbon\Carbon::parse($detail_pernikahan->tgl_pernikahan)->isoFormat('dddd, DD MMMM Y HH:mm') }} @endif"
                    class="w-full p-2 rounded bg-white border border-gray-300" disabled>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">NAMA PASANGAN</label>
                <input type="text" placeholder="Nama Pasangan Tidak Ditemukan"
                    value="{{ $pasangan?->nama_jemaat ?? '' }}"
                    class="w-full p-2 rounded bg-white border border-gray-300" disabled>
            </div>
            <div class="mb-6">
                <label class="block font-semibold mb-1">NAMA PENDETA</label>
                <input type="text" class="w-full p-2 rounded bg-white border border-gray-300"
                    value="@if ($data_pernikahan == null) Belum Mengajukan Pernikahan
                    @elseif($detail_pernikahan->id_pendeta == null) Nama Pendeta Tidak Ditemukan
                    @else {{ $detail_pernikahan->pendeta->jemaat->nama_jemaat }} @endif"
                    disabled>
            </div>

            <!-- Submission Table -->
            <div class="mb-4">
                <label class="block font-semibold mb-2">PENGAJUAN SAYA</label>
                <table class="w-full border-collapse ">
                    <thead>
                        <tr class="bg-white text-sm font-semibold">
                            <th class="border border-gray-300 px-4 py-2">TANGGAL PENGAJUAN</th>
                            <th class="border border-gray-300 px-4 py-2">STATUS</th>
                            <th class="border border-gray-300 px-4 py-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Add dynamic rows here -->
                        @if ($data_pernikahan != null)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ \Carbon\Carbon::parse($data_pernikahan->tanggal_pengajuan)->isoFormat('dddd, DD MMMM Y') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($data_pernikahan->verifikasi_pengajuan == 0)
                                        <div class="font-bold text-yellow-500">Menunggu Verifikasi</div>
                                    @elseif ($data_pernikahan->verifikasi_pengajuan == 1)
                                        <div class="font-bold text-green-500">Diverifikasi</div>
                                    @elseif ($data_pernikahan->verifikasi_pengajuan == 2)
                                        <div class="font-bold text-red-500">Ditolak</div>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('PengajuanJemaat.ubah_pernikahan', $data_pernikahan) }}">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Revision Table -->
            @if ($data_pernikahan != null)
                <div>
                    <label class="block font-semibold mb-2">REVISI SAYA</label>
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-white text-sm font-semibold">
                                <th class="border border-gray-300 px-4 py-2">TANGGAL REVISI</th>
                                <th class="border border-gray-300 px-4 py-2">PENGOMENTAR</th>
                                <th class="border border-gray-300 px-4 py-2">KOMENTAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Add dynamic rows here -->
                            @foreach ($data_revisi as $item)
                                <tr class="bg-white text-sm text-center">
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ \Carbon\Carbon::parse($item->tgl_revisi)->translatedFormat('l, d F Y') }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-left">
                                        {{ $item->pengomentar->jemaat->nama_jemaat }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $item->komentar }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $data_revisi->links() }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            @if ($data_pernikahan == null)
                <a href="{{ route('PengajuanJemaat.tambah_pernikahan') }}">
                    <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                        TAMBAH
                    </button>
                </a>
            @elseif ($data_pernikahan->verifikasi_pengajuan == 2)
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    UBAH
                </button>
            @endif
        </div>
    </div>
</x-layout_sistem_informasi>
