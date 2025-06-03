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
                        <input type="text" value="{{ $pengajuan_jemaat->id_pernikahan }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">NAMA PENGAJU</label>
                        <input type="text" value="{{ $pengajuan_jemaat->pengajuan_jemaat->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">CALON SUAMI</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat_pria->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">CALON ISTRI</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat_wanita->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR SUAMI</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value="{{ $pengajuan_jemaat->jemaat_pria->tmpt_lahir_jemaat }}"
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="date" class="w-full p-2 rounded bg-gray-100" name="tgl_lahir_jemaat"
                                value="{{ \Carbon\Carbon::parse($pengajuan_jemaat->jemaat_pria->tgl_lahir_jemaat)->format('Y-m-d') }}"
                                disabled>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR ISTRI</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value="{{ $pengajuan_jemaat->jemaat_wanita->tmpt_lahir_jemaat }}"
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="date" class="w-full p-2 rounded bg-gray-100" name="tgl_lahir_jemaat"
                                value="{{ \Carbon\Carbon::parse($pengajuan_jemaat->jemaat_wanita->tgl_lahir_jemaat)->format('Y-m-d') }}"
                                disabled>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT SUAMI</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat_pria->alamat_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT ISTRI</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat_wanita->alamat_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMOR TELEPON SUAMI</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat_pria->telp_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMOR TELEPON ISTRI</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat_wanita->telp_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL & JAM PERNIKAHAN</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value=" {{ \Carbon\Carbon::parse($pengajuan_jemaat->tgl_pernikahan)->format('d M Y') }} "
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="text" class="w-full p-2 rounded bg-gray-100" name="tgl_lahir_jemaat"
                                value=" {{ \Carbon\Carbon::parse($pengajuan_jemaat->tgl_pernikahan)->format('H:i') }} "
                                disabled>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT PERNIKAHAN</label>
                        <input type="text" name="tmpt_lahir_jemaat"
                            value=" {{ $pengajuan_jemaat->tempat_pernikahan }} " class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                </div>
                {{-- untuk mendapatkan komentar dan verifikasi --}}
                <input type="hidden" name="catatan_pengajuan" id="catatan_pengajuan">
                <input type="hidden" name="verifikasi_pengajuan" id="verifikasi_pengajuan">
                <input type="hidden" name="id_pendeta" id="tempat_pernikahan">
        </form>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="/manajemen/pengajuan">
                <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
            <button type="button" class="bg-red-700  px-6 py-2 rounded-md hover:bg-red-800"
                onclick="showAlertDecline()">
                TOLAK
            </button>
            <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                onclick="showAlertVerify()">
                VERIFIKASI
            </button>
        </div>
    </div>

    <script>
        function showAlertDecline() {
            Swal.fire({
                title: "Tolak verifikasi?",
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
                    Swal.fire("Data Ditolak", "Catatan: " + catatan_pengajuan, "success");
                    // Submit the form
                    document.getElementById('catatan_pengajuan').value = catatan_pengajuan;
                    document.getElementById('verifikasi_pengajuan').value = 2;
                    document.getElementById('verifikasiForm').submit();
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
                        text: `Nama pembaptis: ${document.getElementById('swal-nama_pendeta').value}`,
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
                    }, 2000);
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Diverifikasi", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
