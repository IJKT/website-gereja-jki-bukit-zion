<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="flex-1 bg-gray-100 p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @if (Auth::user()->jemaat->hak_akses_jemaat == 'Pelayan')
                <!-- Statistik -->
                @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Koordinator' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator')
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold mb-4">Statistik</h2>
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <p class="text-md font-bold">{{ count($jemaat) }}</p>
                                <p class="text-sm text-gray-600">Jemaat</p>
                            </div>
                            <div>
                                <p class="text-md font-bold">{{ count($pelayan) }}</p>
                                <p class="text-sm text-gray-600">Pelayan</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Verifikasi -->
                @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Koordinator' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator')
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold mb-4">Perlu di Verifikasi</h2>
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <p class="text-md font-bold">{{ count($pembukuan) }}</p>
                                <a href="{{ route('Pembukuan.viewall') }}"
                                    class="text-sm text-gray-600 hover:underline">Pembukuan</a>
                            </div>
                            <div>
                                <p class="text-md font-bold">{{ count($pengajuan_jemaat) }}</p>
                                <a href="{{ route('Manajemen.Jemaat.Pengajuan.viewall') }}"
                                    class="text-sm text-gray-600 hover:underline">Pengajuan</a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Kontak -->
                @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Koordinator' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator')
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold mb-4">Kontak Jemaat</h2>
                        <div class="text-center">
                            <div>
                                <p class="text-md font-bold">{{ count($kontak) }}</p>
                                <a href="{{ route('Kontak.index') }}"
                                    class="text-sm text-gray-600 hover:underline">Belum Dibalas</a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Jadwal -->
                <div class="bg-white p-4 rounded-lg shadow-md md:col-span-3">
                    <h2 class="text-lg font-semibold mb-4">Jadwal</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse ">
                            <thead>
                                <tr class="bg-white text-sm font-semibold">
                                    <th class="border border-gray-300 px-4 py-2">TANGGAL IBADAH</th>
                                    <th class="border border-gray-300 px-4 py-2">TIPE IBADAH</th>
                                    <th class="border border-gray-300 px-4 py-2">PERAN</th>
                                    <th class="border border-gray-300 px-4 py-2">PUJIAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal as $_jadwal)
                                    <tr class="bg-white text-sm text-center">
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ \Carbon\Carbon::parse($_jadwal->jadwal_ibadah->tgl_ibadah)->isoFormat(' dddd, DD MMMM Y HH:mm') }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $_jadwal->jadwal_ibadah->jenis_ibadah }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ [
                                                1 => 'Pendeta',
                                                2 => 'Worship Leader',
                                                3 => 'Singer',
                                                4 => 'Keyboard',
                                                5 => 'Drum',
                                                6 => 'Bass',
                                                7 => 'Guitar',
                                                8 => 'Video',
                                                9 => 'Photo',
                                                10 => 'Live Stream',
                                                11 => 'Lyrics',
                                            ][$_jadwal->peran_pelayan] }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a
                                                href="{{ route('Jadwal.viewall_pujian', $_jadwal->jadwal_ibadah->id_jadwal) }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $jadwal->links() }}
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Pengajuanku -->
            @php
                $baptis =
                    Auth::user()->jemaat->pengajuan_jemaat->where('jenis_pengajuan', 'Baptis')->first()
                        ?->verifikasi_pengajuan ?? 'Belum Mengajukan';

                $pernikahan =
                    Auth::user()->jemaat->pengajuan_jemaat->where('jenis_pengajuan', 'Pernikahan')->first()
                        ?->verifikasi_pengajuan ?? 'Belum Mengajukan';
            @endphp

            @if (Auth::user()->verifikasi_user == 1)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold mb-2">Pengajuan Saya</h2>
                    <ul class="list-disc list-inside">
                        @if ($baptis != 'Belum Mengajukan')
                            <li>Status Baptis -
                                <b
                                    class="{{ ['text-yellow-500', 'text-green-500', 'text-red-500', 'text-black', 'text-black'][$baptis] }}">
                                    {{ ['Menunggu Verifikasi', 'Diverifikasi', 'Ditolak', 'Dicetak', 'Diberikan'][$baptis] }}
                                </b>
                            </li>
                        @endif
                        @if ($pernikahan != 'Belum Mengajukan')
                            <li>Status Pernikahan -
                                <b
                                    class="{{ ['text-yellow-500', 'text-green-500', 'text-red-500', 'text-black', 'text-black'][$pernikahan] }}">
                                    {{ ['Menunggu Verifikasi', 'Diverifikasi', 'Ditolak', 'Dicetak', 'Diberikan'][$pernikahan] }}
                                </b>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif

            <!-- Pemberitahuan -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Pemberitahuan</h2>
                <ul class="list-disc list-inside">
                    @foreach ($rangkuman_firman as $_rangkuman_firman)
                        <li>
                            ({{ \Carbon\Carbon::parse($_rangkuman_firman->tgl_rangkuman)->isoFormat('DD MMMM Y') }})
                            -
                            {{ $_rangkuman_firman->tipe_rangkuman }}:
                            <a href="{{ route('Home.single_post', $_rangkuman_firman->slug_rangkuman) }}"
                                class="hover:underline">
                                <strong>{{ Str::limit($_rangkuman_firman->judul_rangkuman, 50) }}</strong>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
