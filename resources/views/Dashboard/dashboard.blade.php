<!-- TODO: buat halaman dashboard-->
<!-- TODO: apakah ini mau ditambahin untuk "PERNAH BAPTIS" dan "CARA BAPTIS"?-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="flex-1 bg-gray-100 p-5">
        <div class="pl-4 py-6 grid grid-cols-1 md:grid-cols-3 gap-6 h-fit">
            <!-- Statistik -->
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

            <!-- Verifikasi -->
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

            <!-- Pengajuanku v2 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Pengajuan Saya</h2>
                <ul class="list-disc list-inside">
                    <li>Status Baptis - <b>Menunggu Verifikasi</b></li>
                    <li>Status Pernikahan - <b>Belum Mengajukan</b></li>
                </ul>
            </div>

            <!-- Pemberitahuan -->
            <div class="bg-white p-4 rounded-lg shadow-md md:col-span-3">
                <h2 class="text-lg font-semibold mb-2">Pemberitahuan</h2>
                <ul class="list-disc list-inside">
                    @foreach ($rangkuman_firman as $_rangkuman_firman)
                        <li>
                            ({{ \Carbon\Carbon::parse($_rangkuman_firman->tgl_rangkuman)->isoFormat('DD MMMM Y') }})
                            -
                            {{ $_rangkuman_firman->tipe_rangkuman }}:
                            <a href="{{ route('Home.single_post', $_rangkuman_firman->slug_rangkuman) }}"
                                class="hover:underline">
                                <strong>{{ Str::limit($_rangkuman_firman->judul_rangkuman, 30) }}</strong>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>



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
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2"> 23 Juni 2025 </td>
                                <td class="border border-gray-300 px-4 py-2"> Sunday Service </td>
                                <td class="border border-gray-300 px-4 py-2"> Worship Leader </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="#">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                    </a>
                                </td>
                            </tr>

                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2">25 Juni 2025</td>
                                <td class="border border-gray-300 px-4 py-2">Shabbat Service</td>
                                <td class="border border-gray-300 px-4 py-2">Video</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="#">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                    </a>
                                </td>
                            </tr>

                            {{-- @foreach ($jadwal as $_jadwal)
                            <tr class="bg-white text-sm text-center">
                                <td class="border border-gray-300 px-4 py-2 text-left">
                                    {{ $_jadwal->jenis_ibadah }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ \Carbon\Carbon::parse($_jadwal->tgl_ibadah)->isoFormat(' dddd, DD MMMM Y HH:mm') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('Jadwal.ubah', $_jadwal->id_jadwal) }}">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
