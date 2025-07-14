<!-- TODO: buat print biar bisa mencetak setiap list pengajuan dari jemaat-->
<!-- TODO: buat filter untuk melihat status -> kalau misalnya difilter dimana yang menunggu verifikasi diatas bagaimana?-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">MANAJEMEN PENGAJUAN JEMAAT</label>

                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <form method="GET" action="{{ route('Manajemen.Jemaat.Pengajuan.viewall') }}">
                            <div class="mx-2 mt-2 mb-4">
                                <label for="jenis_pengajuan" class="block text-sm font-medium text-gray-700">Jenis
                                    Pengajuan</label>
                                <select name="jenis_pengajuan" id="jenis_pengajuan"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Semua</option>
                                    <option value="Baptis">Baptis</option>
                                    <option value="Pernikahan">Pernikahan</option>
                                    <option value="Registrasi">Registrasi</option>
                                </select>
                            </div>
                    </x-filter-dropdown>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-white text-sm font-semibold">
                                <th class="border border-gray-300 px-4 py-2">NAMA LENGKAP</th>
                                <th class="border border-gray-300 px-4 py-2">JENIS PENGAJUAN</th>
                                <th class="border border-gray-300 px-4 py-2">STATUS</th>
                                <th class="border border-gray-300 px-4 py-2">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuan_jemaat as $_pengajuan_jemaat)
                                <tr class="bg-white text-sm text-center">
                                    <td class="border border-gray-300 px-4 py-2 text-left">
                                        {{ $_pengajuan_jemaat->jemaat->nama_jemaat }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $_pengajuan_jemaat['jenis_pengajuan'] }}</td>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">
                                        @if ($_pengajuan_jemaat['verifikasi_pengajuan'] == 0)
                                            <div class="text-yellow-600">Menunggu Verifikasi</div>
                                        @elseif ($_pengajuan_jemaat['verifikasi_pengajuan'] == 1)
                                            <div class="text-green-600">Diverifikasi</div>
                                        @elseif ($_pengajuan_jemaat['verifikasi_pengajuan'] == 2)
                                            <div class="text-red-600">Ditolak</div>
                                        @elseif ($_pengajuan_jemaat['verifikasi_pengajuan'] == 3)
                                            <div>Dicetak</div>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($_pengajuan_jemaat['jenis_pengajuan'] == 'Baptis')
                                            <a
                                                href="{{ route('Manajemen.Jemaat.Pengajuan.verifikasi_baptis', $_pengajuan_jemaat->id_pengajuan) }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                            </a>
                                        @elseif ($_pengajuan_jemaat['jenis_pengajuan'] == 'Pernikahan')
                                            <a
                                                href="{{ route('Manajemen.Jemaat.Pengajuan.verifikasi_pernikahan', $_pengajuan_jemaat->id_pengajuan) }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                            </a>
                                        @elseif ($_pengajuan_jemaat['jenis_pengajuan'] == 'Registrasi')
                                            <a
                                                href="{{ route('Manajemen.Jemaat.Pengajuan.verifikasi_registrasi', $_pengajuan_jemaat->id_pengajuan) }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-2">
                    <div>
                        {{ $pengajuan_jemaat->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="{{ route('Manajemen.Jemaat.Pengajuan.unduh', request()->query()) }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    UNDUH
                </button>
            </a>
            <a href="{{ route('Manajemen.Jemaat.viewall') }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    KEMBALI
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
