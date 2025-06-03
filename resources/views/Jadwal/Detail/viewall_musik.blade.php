<!-- TODO: bikin biar bisa hapus file -->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->

                {{-- @php
                    // Make sure Carbon is imported and locale is set to Indonesian
                    \Carbon\Carbon::setLocale('id');
                    // Parse the date and format it as 'dddd, D MMMM Y' (e.g., Minggu, 1 Juni 2025)
                    $tanggalIndo = \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('dddd, D MMMM Y');
                @endphp --}}

                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">JADWAL PRAISE & WORSHIP {{ $jadwal->jenis_ibadah }} -
                        {{ \Carbon\Carbon::parse($jadwal->tgl_ibadah)->translatedFormat('l, d M Y') }}</label>
                    <button class="bg-[#215773] text-white px-2 py-2 rounded hover:bg-[#1a4a60]">
                        <!-- Replace with icon if needed -->
                        <svg class="h-5 w-5 font-bold" viewBox="0 0 15 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 2.5H15M3 7.5H12M5 12.5H10" stroke="#ffffff" />
                        </svg>
                    </button>
                </div>
                <div class="mb-2">
                    <span class="font-semibold">PENDETA :</span>
                    @if (isset($pendeta->id_pelayan))
                        {{ $pendeta->pelayan->jemaat->nama_jemaat }}
                    @else
                        {{ $pendeta->nama_pendeta_undangan }}
                    @endif
                </div>
                <table class="w-full border-collapse ">
                    <thead>
                        <tr class="bg-white text-sm font-semibold">
                            <th class="border border-gray-300 px-4 py-2">NAMA LENGKAP</th>
                            <th class="border border-gray-300 px-4 py-2">PERAN PELAYAN</th>
                            <th class="border border-gray-300 px-4 py-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelayan_musik as $_pelayan_musik)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2 text-left">
                                    {{ $_pelayan_musik->pelayan->jemaat->nama_jemaat }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($_pelayan_musik->peran_pelayan == 2)
                                        Worship Leader
                                    @elseif($_pelayan_musik->peran_pelayan == 3)
                                        Singer
                                    @elseif($_pelayan_musik->peran_pelayan == 4)
                                        Keyboard
                                    @elseif($_pelayan_musik->peran_pelayan == 5)
                                        Drum
                                    @elseif($_pelayan_musik->peran_pelayan == 6)
                                        Bass
                                    @elseif($_pelayan_musik->peran_pelayan == 7)
                                        Guitar
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a
                                        href="{{ route('Jadwal.ubah_musik', [$jadwal->id_jadwal, $_pelayan_musik->id_pelayan]) }}">
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

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="/jadwal/musik/tambah/{{ $jadwal->id_jadwal }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    TAMBAH
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
