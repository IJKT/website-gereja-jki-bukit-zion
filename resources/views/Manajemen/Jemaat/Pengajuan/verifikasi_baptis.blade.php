<!-- TODO: setelah diberikan, hal yang bisa dilakukan adalah untuk melihat saja -->
<!-- ROADMAP
Verifikasi   -> Dicetak     -> Diberikan
-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Main Content --}}
    <div class="flex-1 bg-white p-10">
        <form id="verifikasiForm" action="{{ route('Manajemen.Jemaat.Pengajuan.verify_baptis', $pengajuan_jemaat) }}"
            method="POST" enctype="multipart/form-data">
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
                <input type="hidden" name="nama_baptis" id="nama_baptis_hidden">
        </form>

        <!-- Revision Table -->
        <div>
            <label class="block font-semibold mb-2">REVISI SEBELUMNYA</label>
            <div class="overflow-x-auto">
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
            </div>
            
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
            @if ($pengajuan_jemaat->verifikasi_pengajuan == 1)
                {{-- <a href="{{ route('Manajemen.Jemaat.Pengajuan.preview_baptis', $pengajuan_jemaat) }}">
                    <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                        PREVIEW CETAK
                    </button>
                </a> --}}
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                    onclick="showAlertCetak()">
                    CETAK
                </button>
            @endif
            <a href="{{ route('Manajemen.Jemaat.Pengajuan.viewall') }}">
                <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
        </div>
    </div>

    <script>
        function showAlertCetak() {
            Swal.fire({
                title: 'Persiapan Cetak Sertifikat',
                html: `
                <div class="text-left">
                    <label for="swal-nama-baptis" class="swal2-label">Nama Baptis</label>
                    {{-- Menggunakan preferensi nama baptis sebagai nilai default --}}
                    <input id="swal-nama-baptis" type="text" class="swal2-input" placeholder="Masukkan nama baptis">

                    <label for="swal-foto-baptis" class="swal2-label mt-4">Upload Foto Jemaat </label>
                    <input id="swal-foto-baptis" type="file" class="swal2-file" accept="image/*">
                    
                    <div class="mt-4 flex justify-center">
                        <img id="swal-image-preview" src="#" alt="Pratinjau Gambar" class="rounded-md" style="max-height: 200px; display: none;">
                    </div>
                </div>
            `,
                confirmButtonText: 'Lanjutkan & Cetak',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                customClass: {
                    file: 'w-full border p-2 rounded-md'
                },
                didOpen: () => {
                    const fileInput = document.getElementById('swal-foto-baptis');
                    const imagePreview = document.getElementById('swal-image-preview');

                    fileInput.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                imagePreview.src = e.target.result;
                                imagePreview.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        } else {
                            imagePreview.src = '#';
                            imagePreview.style.display = 'none';
                        }
                    });
                },
                preConfirm: () => {
                    const namaBaptis = document.getElementById('swal-nama-baptis').value;
                    if (!namaBaptis) {
                        Swal.showValidationMessage('Nama Baptis tidak boleh kosong!');
                        return false;
                    }
                    return {
                        namaBaptis: namaBaptis,
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('verifikasiForm');
                    const fileInput = document.getElementById('swal-foto-baptis');

                    // 1. HAPUS input _method=PUT agar form menjadi POST murni
                    const methodInput = form.querySelector('input[name="_method"]');
                    if (methodInput) {
                        methodInput.remove();
                    }

                    // 2. Set action, target, dan values
                    form.action = "{{ route('Manajemen.Jemaat.Pengajuan.cetak_baptis', $pengajuan_jemaat) }}";
                    document.getElementById('nama_baptis_hidden').value = result.value.namaBaptis;
                    if (fileInput.files.length > 0) {
                        fileInput.name = 'foto_baptis';
                        form.appendChild(fileInput);
                    }

                    // 3. Submit form
                    form.submit();

                    // 4. Kembalikan form ke keadaan semula
                    setTimeout(() => {
                        // Buat kembali input _method=PUT menggunakan JavaScript
                        if (!form.querySelector('input[name="_method"]')) {
                            const putInput = document.createElement('input');
                            putInput.type = 'hidden';
                            putInput.name = '_method';
                            putInput.value = 'PUT';
                            form.prepend(putInput);
                        }
                        form.action =
                            "{{ route('Manajemen.Jemaat.Pengajuan.verify_baptis', $pengajuan_jemaat) }}";
                        form.target = '_self';
                    }, 500);
                }
            });
        }


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
