<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Main Content --}}
    <div class="flex-1 bg-white p-10">
        <form id="jemaatForm" action="{{ route('Manajemen.Jemaat.update', $jemaat) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">UBAH DATA JEMAAT</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID JEMAAT</label>
                        <input type="text" value="{{ $jemaat->id_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">USERNAME</label>
                        <input type="text" value="{{ $jemaat->username }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                        <input type="text" name="nama_jemaat" value="{{ old('nama_jemaat', $jemaat->nama_jemaat) }}"
                            class="w-full p-2 rounded bg-white" required autocomplete="off">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">EMAIL</label>
                        <input type="text" name="email_jemaat"
                            value="{{ old('email_jemaat', $jemaat->email_jemaat) }}" class="w-full p-2 rounded bg-white"
                            required autocomplete="off">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NIK</label>
                        <input type="text" name="nik_jemaat" id="nik_jemaat"
                            value="{{ old('nik_jemaat', $jemaat->nik_jemaat) }}" class="w-full p-2 rounded bg-white"
                            required maxlength="16" pattern="\d*" inputmode="numeric" autocomplete="off"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16);">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT</label>
                        <input type="text" name="alamat_jemaat"
                            value="{{ old('alamat_jemaat', $jemaat->alamat_jemaat) }}"
                            class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value="{{ old('tmpt_lahir_jemaat', $jemaat->tmpt_lahir_jemaat) }}"
                                class="w-full p-2 rounded bg-white" required>
                            <input type="date" class="w-full p-2 rounded bg-white" name="tgl_lahir_jemaat"
                                value="{{ old('tgl_lahir_jemaat', \Carbon\Carbon::parse($jemaat->tgl_lahir_jemaat)->format('Y-m-d')) }}"
                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMOR TELEPON</label>
                        <input type="text" name="telp_jemaat" id="telp_jemaat"
                            value="{{ old('telp_jemaat', $jemaat->telp_jemaat) }}" class="w-full p-2 rounded bg-white"
                            required maxlength="20" pattern="\d*" inputmode="numeric" autocomplete="off"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,20);">
                    </div>
                    <!-- TODO: tambahin input form buat pekerjaan dan wilayah komsel -->
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL BAPTIS</label>
                        <input type="text"
                            value="@if ($baptis != null) @if ($baptis->verifikasi_pengajuan == 1) {{ $baptis->baptis->tgl_baptisa }} @else Data Baptis Belum Diverifikasi @endif @endif"
                            class="w-full p-2 rounded bg-gray-100" placeholder="Data Baptis Belum Ditemukan" disabled>
                    </div>
                    <div>
                        @isset($pernikahan)
                            @php
                                $data_pernikahan = $pernikahan->pernikahan->first();
                            @endphp
                        @endisset
                        <label class="block font-semibold mb-1">NAMA PASANGAN</label>
                        <input type="text"
                            value="@isset($pernikahan) @if ($pernikahan->verifikasi_pengajuan) {{ $jemaat->jk_jemaat == 'P' ? $data_pernikahan->jemaat_wanita->nama_jemaat : $data_pernikahan->jemaat_pria->nama_jemaat }} @else Data Pernikahan Belum Diverifikasi @endif @endisset"
                            class="w-full p-2 rounded bg-gray-100" placeholder="Data Pernikahan Belum Ditemukan"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">WILAYAH KOMSEL</label>
                        <input type="text" value="{{ $jemaat->wilayah_komsel_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" placeholder="Wilayah Komsel Belum Ditemukan"
                            disabled>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-10">
                    <div>
                        <label class="block font-semibold my-1">HAK AKSES</label>
                        <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="hak_akses_jemaat" value="Jemaat"
                                    class="form-radio text-[#215773]"
                                    {{ old('hak_akses_jemaat', $jemaat->hak_akses_jemaat) == 'Jemaat' ? 'checked' : '' }}>
                                <span :class="hak_akses == 'Jemaat' ? 'font-semibold' : 'font-normal'">Jemaat</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="hak_akses_jemaat" value="Pelayan"
                                    class="form-radio text-[#215773]"
                                    {{ old('hak_akses_jemaat', $jemaat->hak_akses_jemaat) == 'Pelayan' ? 'checked' : '' }}>
                                <span :class="hak_akses == 'Pelayan' ? 'font-semibold' : 'font-normal'">Pelayan</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold my-1">JENIS KELAMIN</label>
                        <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="jk_jemaat" value="P" class="form-radio text-[#215773]"
                                    {{ old('jk_jemaat', $jemaat->jk_jemaat) == 'P' ? 'checked' : '' }}>
                                <span :class="hak_akses == 'P' ? 'font-semibold' : 'font-normal'">Pria</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="jk_jemaat" value="W"
                                    class="form-radio text-[#215773]"
                                    {{ old('jk_jemaat', $jemaat->jk_jemaat) == 'W' ? 'checked' : '' }}>
                                <span :class="hak_akses == 'W' ? 'font-semibold' : 'font-normal'">Wanita</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <form id="statusForm" action="{{ route('Manajemen.Jemaat.status', $jemaat) }}" method="POST"
                style="display:none;">
                @csrf
                @method('PUT')
                <input type="hidden" name="status_jemaat" value="{{ $jemaat->status_jemaat == 1 ? 0 : 1 }}">
            </form>
            @if ($jemaat->status_jemaat == 1)
                <button type="button" class="bg-red-500  px-6 py-2 rounded-md hover:bg-red-700"
                    onclick="showAlertNonactivate()">
                    NONAKTIF
                </button>
            @elseif ($jemaat->status_jemaat == 0)
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                    onclick="showAlertActivate()">
                    AKTIF
                </button>
            @endif
            <a href="{{ route('Manajemen.Jemaat.viewall') }}">
                <button type="button"
                    class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
            <button
                class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200"
                id="simpanBtn" onclick="showAlertSave()" disabled>
                SIMPAN
            </button>
        </div>
    </div>

    <script>
        // Telp Jemaat: Only numbers, no spaces, max 20 chars
        document.addEventListener('DOMContentLoaded', function() {
            const telpInput = document.getElementById('telp_jemaat');
            if (telpInput) {
                telpInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 20);
                });
                telpInput.addEventListener('paste', function(e) {
                    e.preventDefault();
                    let paste = (e.clipboardData || window.clipboardData).getData('text');
                    paste = paste.replace(/[^0-9]/g, '').slice(0, 20);
                    document.execCommand('insertText', false, paste);
                });
            }
        });
        // Function to check if all required fields are filled
        function checkRequiredFields() {
            const form = document.getElementById('jemaatForm');
            const requiredFields = form.querySelectorAll('[required]');
            let allFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFilled = false;
                }
            });
            document.getElementById('simpanBtn').disabled = !allFilled;
        }
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jemaatForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
            });
            checkRequiredFields();
        });

        function showAlertSave() {
            Swal.fire({
                title: "Simpan Data Jemaat?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Data Jemaat Diperbarui", "", "success");
                    document.getElementById('jemaatForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Data Jemaat Tidak Disimpan", "", "error");
                }
            });
        }

        function showAlertNonactivate() {
            Swal.fire({
                title: "Nonaktifkan Jemaat?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Jemaat Dinonaktifkan", "", "success");
                    // Submit the status form
                    document.getElementById('statusForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Jemaat Tidak Diubah", "", "error");
                }
            });
        }

        function showAlertActivate() {
            Swal.fire({
                title: "Aktifkan Jemaat?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Jemaat Diaktifkan", "", "success");
                    // Submit the status form
                    document.getElementById('statusForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Jemaat Tidak Diubah", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
