<!-- TODO: buat biar bisa dilihat lagi setelah di verif, tapi tidak usah bisa dibuat bisa diverif lagi -->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Main Content --}}
    <div class="flex-1 bg-white p-10">
        <form id="verifikasiForm" action="{{ route('Manajemen.Jemaat.Pengajuan.verify_baptis', $pengajuan_jemaat) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">VERIFIKASI DATA BAPTIS</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PENGAJUAN</label>
                        <input type="text" value="{{ $pengajuan_jemaat->id_pengajuan }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">JENIS KELAMIN</label>
                        <input type="text" value=" @if ($pengajuan_jemaat->jemaat->jk_jemaat == 'P') Pria @else Wanita @endif"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value="{{ $pengajuan_jemaat->jemaat->tmpt_lahir_jemaat }}"
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="date" class="w-full p-2 rounded bg-gray-100" name="tgl_lahir_jemaat"
                                value="{{ \Carbon\Carbon::parse($pengajuan_jemaat->jemaat->tgl_lahir_jemaat)->format('Y-m-d') }}"
                                disabled>
                        </div>
                    </div>
                    {{-- <div>
                        <label class="block font-semibold mb-1">PEKERJAAN</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->pekerjaan_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" placeholder="Belum/Tidak Bekerja" disabled>
                    </div> --}}
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->alamat_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMOR TELEPON</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->telp_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">KOMSEL</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->wilayah_komsel_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100"
                            placeholder="Belum/Tidak Bergabung di sebuah cellgroup" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">PREFERENSI NAMA BAPTIS</label>
                        <input type="text" value="{{ $detail_baptis->preferensi_nama_baptis }}"
                            class="w-full p-2 rounded bg-gray-100" disabled placeholder="Tidak Ada Preferensi">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">PENGAJAR KELAS BAPTIS</label>
                        <input type="text" value="{{ $detail_baptis->pengajar->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                </div>
                {{-- untuk mendapatkan hidden input --}}
                <input type="hidden" name="catatan_pengajuan" id="catatan_pengajuan">
                <input type="hidden" name="tgl_baptis" id="tgl_baptis">
                <input type="hidden" name="verifikasi_pengajuan" id="verifikasi_pengajuan">
        </form>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                onclick="showAlertVerify()">
                VERIFIKASI
            </button>
            <button type="button" class="bg-red-700  px-6 py-2 rounded-md hover:bg-red-800"
                onclick="showAlertDecline()">
                TOLAK
            </button>
            <a href="{{ route('Manajemen.Jemaat.Pengajuan.viewall') }}">
                <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
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
                    Swal.fire("Data Penolakan Berhasil Disimpan", "Catatan: " + catatan_pengajuan, "success");
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
            <label for="swal-tgl-baptis">Tanggal Baptis</label>
            <input id="swal-tgl-baptis" type="datetime-local" class="swal2-input" style="width:80%">
            <label for="swal-nama_pembaptis">Nama Pembaptis</label>
            <input id="swal-nama_pembaptis" type="text" class="swal2-input" style="width:80%" autocomplete="off">
            <div id="swal-pembaptis-suggestion-list" style="position:relative; z-index:9999; background:white; border:1px solid #ccc; border-radius:4px; display:none; max-height:150px; overflow-y:auto;"></div>
            <input id="swal-id_pembaptis" type="hidden">
        `,
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal',
                preConfirm: () => {
                    const tgl_baptis = document.getElementById('swal-tgl-baptis').value;
                    const id_pembaptis = document.getElementById('swal-id_pembaptis').value;
                    if (!tgl_baptis) {
                        Swal.showValidationMessage('Tanggal baptis harus diisi!');
                        return false;
                    }
                    if (!id_pembaptis) {
                        Swal.showValidationMessage('Nama pembaptis harus dipilih dari daftar!');
                        return false;
                    }
                    return {
                        tgl_baptis,
                        id_pembaptis
                    };
                },
                didOpen: () => {
                    // Set min date to now
                    const input = document.getElementById('swal-tgl-baptis');
                    if (input) {
                        const now = new Date();
                        const yyyy = now.getFullYear();
                        const mm = String(now.getMonth() + 1).padStart(2, '0');
                        const dd = String(now.getDate()).padStart(2, '0');
                        const hh = String(now.getHours()).padStart(2, '0');
                        const min = String(now.getMinutes()).padStart(2, '0');
                        input.min = `${yyyy}-${mm}-${dd}T${hh}:${min}`;
                    }

                    // Suggestion box logic for Nama Pembaptis
                    const namaInput = document.getElementById('swal-nama_pembaptis');
                    const idInput = document.getElementById('swal-id_pembaptis');
                    const suggestionBox = document.getElementById('swal-pembaptis-suggestion-list');
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
                        tgl_baptis,
                        id_pembaptis
                    } = result.value;
                    Swal.fire({
                        title: "Data Diverifikasi",
                        text: `Jemaat akan dibaptis pada ${new Date(tgl_baptis).toLocaleString('id-ID')}.`,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    // Set form values and submit
                    document.getElementById('catatan_pengajuan').value = '';
                    document.getElementById('tgl_baptis').value = tgl_baptis;
                    document.getElementById('verifikasi_pengajuan').value = 1;
                    // Add a hidden input for id_pembaptis if needed in your form
                    let idPembaptisInput = document.getElementById('id_pembaptis');
                    if (!idPembaptisInput) {
                        idPembaptisInput = document.createElement('input');
                        idPembaptisInput.type = 'hidden';
                        idPembaptisInput.name = 'id_pembaptis';
                        idPembaptisInput.id = 'id_pembaptis';
                        document.getElementById('verifikasiForm').appendChild(idPembaptisInput);
                    }
                    idPembaptisInput.value = id_pembaptis;
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
