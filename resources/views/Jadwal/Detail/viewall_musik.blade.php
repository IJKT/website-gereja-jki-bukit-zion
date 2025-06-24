<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <!-- Submission Table -->
            <div>
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold">JADWAL PRAISE & WORSHIP {{ $jadwal->jenis_ibadah }} -
                        {{ \Carbon\Carbon::parse($jadwal->tgl_ibadah)->isoFormat(' dddd, DD MMMM Y HH:mm') }}</label>
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
                                    <form id="form-hapus-{{ $_pelayan_musik->id_pelayan }}"
                                        action="{{ route('Jadwal.hapus_musik', [$jadwal->id_jadwal, $_pelayan_musik->id_pelayan]) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete('{{ $_pelayan_musik->id_pelayan }}')"
                                            class="bg-red-600 text-white font-semibold px-4 py-2 rounded hover:bg-red-700">
                                            HAPUS
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="{{ route('Jadwal.tambah_musik', $jadwal->id_jadwal) }}">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    TAMBAH
                </button>
            </a>
            <a href="{{ route('Jadwal.ubah', $jadwal->id_jadwal) }}">
                <button class="text-[#215773] px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    KEMBALI
                </button>
            </a>
        </div>
    </div>
    </div>

    <script>
        function confirmDelete(idPelayan) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Apakah Anda ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + idPelayan).submit();
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
