<!-- TODO: buat biar bisa dilihat lagi setelah di verif, tapi tidak usah bisa dibuat bisa diverif lagi -->
<!-- TODO: apabila sudah diverif, langkah selanjutnya yang bisa dilakukan adalah dicetak -->
<!-- TODO: setelah diberikan, hal yang bisa dilakukan adalah untuk melihat saja -->
<!-- ROADMAP
Verifikasi   -> Dicetak     -> Diberikan
-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Main Content --}}
    <div class="flex-1 bg-white p-10">
        <form id="verifikasiForm" action="{{ route('Manajemen.Jemaat.Pengajuan.verify_pernikahan', $pengajuan_jemaat) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">VERIFIKASI DATA PERNIKAHAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PENGAJUAN</label>
                        <input type="text" value="{{ $pengajuan_jemaat->id_pengajuan }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">NAMA PENGAJU</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">CALON SUAMI</label>
                        <input type="text" value="{{ $detail_pernikahan->jemaat_pria->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">CALON ISTRI</label>
                        <input type="text" value="{{ $detail_pernikahan->jemaat_wanita->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR SUAMI</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value="{{ $detail_pernikahan->jemaat_pria->tmpt_lahir_jemaat }}"
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="date" class="w-full p-2 rounded bg-gray-100" name="tgl_lahir_jemaat"
                                value="{{ \Carbon\Carbon::parse($detail_pernikahan->jemaat_pria->tgl_lahir_jemaat)->format('Y-m-d') }}"
                                disabled>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR ISTRI</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value="{{ $detail_pernikahan->jemaat_wanita->tmpt_lahir_jemaat }}"
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="date" class="w-full p-2 rounded bg-gray-100" name="tgl_lahir_jemaat"
                                value="{{ \Carbon\Carbon::parse($detail_pernikahan->jemaat_wanita->tgl_lahir_jemaat)->format('Y-m-d') }}"
                                disabled>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT SUAMI</label>
                        <input type="text" value="{{ $detail_pernikahan->jemaat_pria->alamat_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT ISTRI</label>
                        <input type="text" value="{{ $detail_pernikahan->jemaat_wanita->alamat_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMOR TELEPON SUAMI</label>
                        <input type="text" value="{{ $detail_pernikahan->jemaat_pria->telp_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMOR TELEPON ISTRI</label>
                        <input type="text" value="{{ $detail_pernikahan->jemaat_wanita->telp_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL & JAM PERNIKAHAN</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value=" {{ \Carbon\Carbon::parse($detail_pernikahan->tgl_pernikahan)->format('d M Y') }} "
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="text" class="w-full p-2 rounded bg-gray-100" name="tgl_lahir_jemaat"
                                value=" {{ \Carbon\Carbon::parse($detail_pernikahan->tgl_pernikahan)->format('H:i') }} "
                                disabled>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT PERNIKAHAN</label>
                        <input type="text" name="tmpt_lahir_jemaat"
                            value=" {{ $detail_pernikahan->tempat_pernikahan }} "
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">BERKAS PERNIKAHAN</label>
                        <div class="relative">
                            <input type="file" name="berkas" id="berkas" accept=".zip, .rar" class="hidden"
                                disabled>
                            <label for="berkas" id="berkas-label" class="w-full p-2 rounded bg-gray-100 block">
                                {{ \Illuminate\Support\Str::after($detail_pernikahan->berkas_pernikahan ?? '', 'pernikahan/') }}
                            </label>
                        </div>
                        <span id="berkas-filename" class="block text-sm text-gray-700 mt-1"></span>
                        <div class="flex items-center space-x-2 mt-2">
                            <a href="{{ asset('storage/' . $detail_pernikahan->berkas_pernikahan) }}" download
                                class="px-3 py-1 bg-[#215773] text-white rounded hover:bg-[#1a4a60]">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"
                                    enable-background="new 0 0 32 32" xml:space="preserve" class="h-5 w-5 font-bold">
                                    <line fill="none" stroke="currentColor" stroke-width="2" stroke-miterlimit="10"
                                        x1="25" y1="28" x2="7" y2="28" />
                                    <line fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-miterlimit="10" x1="16" y1="23" x2="16"
                                        y2="4" />
                                    <polyline fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-miterlimit="10" points="9,16 16,23 23,16 " />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- untuk mendapatkan komentar dan verifikasi --}}
                <input type="hidden" name="catatan_pengajuan" id="catatan_pengajuan">
                <input type="hidden" name="verifikasi_pengajuan" id="verifikasi_pengajuan">
                <input type="hidden" name="id_pendeta" id="tempat_pernikahan">
        </form>

        <!-- Revision Table -->
        <div>
            <label class="block font-semibold mb-2">REVISI SEBELUMNYA</label>
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

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            @if ($pengajuan_jemaat->verifikasi_pengajuan == 0)
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                    onclick="showAlertVerify()">
                    VERIFIKASI
                </button>
                <button type="button" class="bg-red-700  px-6 py-2 rounded-md hover:bg-red-800"
                    onclick="showAlertDecline()">
                    TOLAK
                </button>
            @endif
            <a href="{{ route('Manajemen.Jemaat.Pengajuan.viewall') }}">
                <button type="button"
                    class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
        </div>
    </div>

    <script>
        function showAlertDecline() {
            Swal.fire({
                title: "Tolak Verifikasi?",
                input: 'text',
                inputLabel: 'Alasan penolakan',
                inputAttributes: {
                    autocomplete: 'off'
                },
                inputPlaceholder: 'Masukkan catatan penolakan',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const catatan_pengajuan = result.value;
                    Swal.fire("Data Penolakan Berhasil Disimpan", "Catatan: " + catatan_pengajuan, "success");
                    // Submit the form
                    document.getElementById('catatan_pengajuan').value = catatan_pengajuan;
                    document.getElementById('verifikasi_pengajuan').value = 2;
                    setTimeout(() => {
                        document.getElementById('verifikasiForm').submit();
                    }, 1000); // Wait for 1 seconds
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Ditolak", "", "error");
                }
            });
        }

        function showAlertVerify() {
            Swal.fire({
                title: "Verifikasi Data?",
                html: `
                <label for="swal-nama_pendeta">Nama Pendeta</label>
                <input id="swal-nama_pendeta" type="text" class="swal2-input" style="width:80%" autocomplete="off">
                <div id="swal-pendeta-suggestion-list" style="position:relative; z-index:9999; background:white; border:1px solid #ccc; border-radius:4px; display:none; max-height:150px; overflow-y:auto;"></div>
                <input id="swal-id_pendeta" type="hidden">
            `,
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal',
                preConfirm: () => {
                    const id_pendeta = document.getElementById('swal-id_pendeta').value;
                    if (!id_pendeta) {
                        Swal.showValidationMessage('Nama pendeta harus dipilih dari daftar!');
                        return false;
                    }
                    return {
                        id_pendeta
                    };
                },
                didOpen: () => {
                    // Suggestion box logic for Nama Pembaptis
                    const namaInput = document.getElementById('swal-nama_pendeta');
                    const idInput = document.getElementById('swal-id_pendeta');
                    const suggestionBox = document.getElementById('swal-pendeta-suggestion-list');
                    let debounceTimeout = null;

                    namaInput.addEventListener('input', function() {
                        idInput.value = ''; // Clear hidden input when typing
                        const query = namaInput.value.trim();
                        if (debounceTimeout) clearTimeout(debounceTimeout);
                        if (query.length < 2) {
                            suggestionBox.style.display = 'none';
                            suggestionBox.innerHTML = '';
                            return;
                        }
                        debounceTimeout = setTimeout(() => {
                            fetch(`/manajemen/pengajuan/search?q=${encodeURIComponent(query)}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.length > 0) {
                                        suggestionBox.innerHTML = data.map(item => `
                                        <div class="swal2-suggestion-item" style="padding:8px; cursor:pointer;" data-id="${item.id_pelayan}" data-name="${item.nama_jemaat}">
                                            ${item.nama_jemaat} (${item.id_pelayan})
                                        </div>
                                    `).join('');
                                        suggestionBox.style.display = 'block';
                                        // Add click listeners
                                        suggestionBox.querySelectorAll(
                                            '.swal2-suggestion-item').forEach(el => {
                                            el.addEventListener('click',
                                                function() {
                                                    namaInput.value = el
                                                        .getAttribute(
                                                            'data-name');
                                                    idInput.value = el
                                                        .getAttribute(
                                                            'data-id');
                                                    suggestionBox.style
                                                        .display = 'none';
                                                });
                                        });
                                    } else {
                                        suggestionBox.innerHTML =
                                            '<div style="padding:8px; color:#888;">Tidak ditemukan</div>';
                                        suggestionBox.style.display = 'block';
                                    }
                                })
                                .catch(() => {
                                    suggestionBox.innerHTML =
                                        '<div style="padding:8px; color:#888;">Error mengambil data</div>';
                                    suggestionBox.style.display = 'block';
                                });
                        }, 250);
                    });

                    // Hide suggestion box when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!suggestionBox.contains(e.target) && e.target !== namaInput) {
                            suggestionBox.style.display = 'none';
                        }
                    }, {
                        capture: true
                    });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const {
                        id_pendeta
                    } = result.value;
                    Swal.fire({
                        title: "Data Diverifikasi",
                        text: `Nama pendeta: ${document.getElementById('swal-nama_pendeta').value}`,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    // Set form values and submit
                    document.getElementById('catatan_pengajuan').value = '';
                    document.getElementById('verifikasi_pengajuan').value = 1;
                    // Add a hidden input for id_pendeta if needed in your form
                    let idPembaptisInput = document.getElementById('id_pendeta');
                    if (!idPembaptisInput) {
                        idPembaptisInput = document.createElement('input');
                        idPembaptisInput.type = 'hidden';
                        idPembaptisInput.name = 'id_pendeta';
                        idPembaptisInput.id = 'id_pendeta';
                        document.getElementById('verifikasiForm').appendChild(idPembaptisInput);
                    }
                    idPembaptisInput.value = id_pendeta;
                    setTimeout(() => {
                        document.getElementById('verifikasiForm').submit();
                    }, 1000);
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Diverifikasi", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
