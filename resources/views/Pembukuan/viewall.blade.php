<!-- TODO: buat tutup buku-->
<!-- TODO: buat kalau mau tambah atau update, bisa dicantumkan jenis pembukuan'nya-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">{{ $label_periode }}</label>
                    {{-- filter button --}}
                    <x-filter-dropdown>
                        <form method="GET" action="{{ route('Pembukuan.viewall') }}">
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
                                <label for="jenis_pembukuan" class="block text-sm font-medium text-gray-700">Jenis
                                    Pembukuan</label>
                                <select name="jenis_pembukuan" id="jenis_pembukuan"
                                    class="bg-white mt-1 pl-2 block w-full rounded focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Semua</option>
                                    <option value="Uang Masuk">Uang Masuk</option>
                                    <option value="Uang Keluar">Uang Keluar</option>
                                </select>
                            </div>
                    </x-filter-dropdown>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-white text-sm font-semibold">
                                <th class="border border-gray-300 px-4 py-2">TANGGAL</th>
                                <th class="border border-gray-300 px-4 py-2">NOMINAL</th>
                                <th class="border border-gray-300 px-4 py-2">JENIS</th>
                                <th class="border border-gray-300 px-4 py-2">DESKRIPSI</th>
                                <th class="border border-gray-300 px-4 py-2">STATUS</th>
                                <th class="border border-gray-300 px-4 py-2">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembukuan as $_pembukuan)
                                <tr class="bg-white text-sm text-center">
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ \Carbon\Carbon::parse($_pembukuan['tgl_pembukuan'])->isoFormat('dddd, DD MMMM Y') }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-left">
                                        {{ 'Rp. ' . number_format($_pembukuan['nominal_pembukuan'], 0, ',', '.') }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $_pembukuan['jenis_pembukuan'] }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <button
                                            class="bg-[#215773] text-white font-semibold px-2 py-2 rounded hover:bg-[#1a4a60]"
                                            onclick="showAlert{{ $_pembukuan['id_pembukuan'] }}()">
                                            <svg fill="#ffffff" class="h-5 w-5 font-bold" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21.92,11.6C19.9,6.91,16.1,4,12,4S4.1,6.91,2.08,11.6a1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20s7.9-2.91,9.92-7.6A1,1,0,0,0,21.92,11.6ZM12,18c-3.17,0-6.17-2.29-7.9-6C5.83,8.29,8.83,6,12,6s6.17,2.29,7.9,6C18.17,15.71,15.17,18,12,18ZM12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 font-bold">
                                        @if ($_pembukuan['verifikasi_pembukuan'] == 1)
                                            <div class="text-green-600">Diverifikasi</div>
                                        @elseif($_pembukuan['verifikasi_pembukuan'] == 0)
                                            <div class="text-yellow-600">Menunggu Verifikasi</div>
                                        @elseif($_pembukuan['verifikasi_pembukuan'] == 2)
                                            <div class="text-red-600">Ditolak</div>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                                                Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Bendahara')
                                            <a href="{{ route('Pembukuan.ubah', $_pembukuan) }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]
                                            @if ($_pembukuan['verifikasi_pembukuan'] == 1) hidden @endif">LIHAT</button>
                                            </a>
                                        @endif

                                        @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                                                Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator')
                                            <a href="{{ route('Pembukuan.verifikasi', $_pembukuan) }}">
                                                <button
                                                    class="bg-[#215773] text-white font-semibold px-4 py-2 rounded hover:bg-[#1a4a60]
                                            @if (in_array($_pembukuan['verifikasi_pembukuan'], [1, 2])) hidden @endif">VERIFIKASI</button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>

                                <script>
                                    function showAlert{{ $_pembukuan['id_pembukuan'] }}() {
                                        Swal.fire({
                                            title: 'DESKRIPSI',
                                            html: `
                                            <strong>Deskripsi:</strong> {{ $_pembukuan->deskripsi_pembukuan }}<br>
                                            @if ($_pembukuan->verifikasi_pembukuan != 1 && !empty($_pembukuan->catatan_pembukuan))
                                                <strong>Komentar:</strong> {{ $_pembukuan->catatan_pembukuan }}<br>
                                            @endif
                                            @if ($_pembukuan->jenis_pembukuan == 'Uang Masuk')
                                                <strong>Jenis Uang Masuk:</strong> {{ $_pembukuan->jenis_pemasukan ?? 'Tidak ada jenis' }}<br>
                                            @endif
                                        `,
                                            icon: 'info',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                </script>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center justify-center font-semibold">Pemasukan:
                        <i> Rp. {{ number_format($total_pemasukan, 0, ',', '.') }}</i>
                    </div>
                    <div class="flex items-center justify-center font-semibold">Pengeluaran:
                        <i> Rp. {{ number_format($total_pengeluaran, 0, ',', '.') }}</i>
                    </div>
                    <div class="flex items-center justify-center font-semibold">Total Saldo:
                        <i> Rp.
                            {{ number_format($total_sisa, 0, ',', '.') }}</i>
                    </div>
                </div>

            </div>
            <div class="mt-2">
                <div>
                    {{ $pembukuan->links() }}
                </div>
            </div>
        </div>

        <!-- Button -->
        <!-- TODO: jangan lupa bikin report buat diunduh. sesuaikan dengan filter -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator')
                <a href="{{ route('Pembukuan.unduh', request()->query()) }}">
                    <button class="bg-[#215773] px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                        UNDUH
                    </button>
                </a>
            @endif
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Bendahara')
                <a href=pembukuan/tambah>
                    <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                        TAMBAH
                    </button>
                </a>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalAwal = document.getElementById('tanggal_awal');
            const tanggalAkhir = document.getElementById('tanggal_akhir');

            function updateMinTanggalAkhir() {
                tanggalAkhir.min = tanggalAwal.value;
                // Optional: if tanggal_akhir is before tanggal_awal, reset it
                if (tanggalAkhir.value < tanggalAwal.value) {
                    tanggalAkhir.value = tanggalAwal.value;
                }
            }

            tanggalAwal.addEventListener('change', updateMinTanggalAkhir);

            // Set initial min on page load
            updateMinTanggalAkhir();
        });
    </script>
</x-layout_sistem_informasi>
