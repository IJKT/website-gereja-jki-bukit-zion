<!-- TODO: apakah ini mau ditambahin untuk "PERNAH BAPTIS" dan "CARA BAPTIS"?-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">

            <!-- Baptism Info -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">TANGGAL BAPTIS</label>
                <input type="text" placeholder="Tanggal Baptis Tidak Ditemukan"
                    value="@if ($data_baptis != null) @if ($data_baptis->verifikasi_pengajuan == 1 || $data_baptis->verifikasi_pengajuan == 3) {{ \Carbon\Carbon::parse($detail_baptis->tgl_baptis)->isoFormat('dddd, DD MMMM Y HH:mm') }}
                    @else Baptis Belum Diverifikasi @endif
                @endif"
                    class="w-full p-2 rounded bg-white border border-gray-300" disabled>
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
                        @if ($data_baptis != null)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ \Carbon\Carbon::parse($data_baptis->tanggal_pengajuan)->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @php
                                        $statusPengajuan = [
                                            0 => ['class' => 'text-yellow-500', 'text' => 'Menunggu Verifikasi'],
                                            1 => ['class' => 'text-green-500', 'text' => 'Diverifikasi'],
                                            2 => ['class' => 'text-red-500', 'text' => 'Ditolak'],
                                            3 => ['class' => 'text-black', 'text' => 'Dicetak'],
                                        ];
                                    @endphp
                                    <div
                                        class="font-bold {{ $statusPengajuan[$data_baptis->verifikasi_pengajuan]['class'] }}">
                                        {{ $statusPengajuan[$data_baptis->verifikasi_pengajuan]['text'] }}
                                    </div>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('PengajuanJemaat.ubah_baptis', $data_baptis) }}">
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
            @if ($data_baptis != null)
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
            @if ($data_baptis == null)
                <a href="{{ route('PengajuanJemaat.tambah_baptis') }}">
                    <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                        TAMBAH
                    </button>
                </a>
            @elseif ($data_baptis->verifikasi_pengajuan == 2)
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    UBAH
                </button>
            @endif

            <!--TODO: tambahkan buat download gambar kalau sudah dinyatakan baptisnya selesai. anggepannya kalo verifikasi pengajuannya = 3-->
        </div>
    </div>
</x-layout_sistem_informasi>
