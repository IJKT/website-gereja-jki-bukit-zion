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
                                        <div class="text-yellow-600">TUNGGU</div>
                                    @elseif ($_pengajuan_jemaat['verifikasi_pengajuan'] == 1)
                                        <div class="text-green-600">VERIF</div>
                                    @elseif ($_pengajuan_jemaat['verifikasi_pengajuan'] == 2)
                                        <div class="text-red-600">TOLAK</div>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($_pengajuan_jemaat['verifikasi_pengajuan'] == 0)
                                        @if ($_pengajuan_jemaat['jenis_pengajuan'] == 'Baptis')
                                            <a
                                                href="/manajemen/pengajuan/baptis/{{ $_pengajuan_jemaat['id_pengajuan'] }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                            </a>
                                        @elseif ($_pengajuan_jemaat['jenis_pengajuan'] == 'Pernikahan')
                                            <a
                                                href="/manajemen/pengajuan/pernikahan/{{ $_pengajuan_jemaat['id_pengajuan'] }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                            </a>
                                        @elseif ($_pengajuan_jemaat['jenis_pengajuan'] == 'Registrasi')
                                            <a
                                                href="/manajemen/pengajuan/registrasi/{{ $_pengajuan_jemaat['id_pengajuan'] }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]">LIHAT</button>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-2">
                    <div>
                        {{ $pengajuan_jemaat->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="{{ route('Manajemen.Jemaat.viewall') }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    KEMBALI
                </button>
            </a>
        </div>
    </div>
    </div>
</x-layout_sistem_informasi>
