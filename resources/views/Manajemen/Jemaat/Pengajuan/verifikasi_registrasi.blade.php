<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- Main Content --}}
    <div class="flex-1 bg-white p-10">
        <form id="verifikasiForm" action="{{ route('Manajemen.Jemaat.Pengajuan.verify_registrasi', $pengajuan_jemaat) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">VERIFIKASI DATA REGISTRASI JEMAAT TETAP</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PENGAJUAN</label>
                        <input type="text" value="{{ $pengajuan_jemaat->id_pengajuan }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">USERNAME</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->username }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                        <input type="text" name="nama_jemaat" value="{{ $pengajuan_jemaat->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">EMAIL</label>
                        <input type="text" name="email_jemaat" value="{{ $pengajuan_jemaat->jemaat->email_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NIK</label>
                        <input type="text" name="nik_jemaat" id="nik_jemaat"
                            value="{{ $pengajuan_jemaat->jemaat->nik_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT</label>
                        <input type="text" name="alamat_jemaat"
                            value="{{ $pengajuan_jemaat->jemaat->alamat_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TANGGAL LAHIR</label>
                        <div class="grid grid-cols-2 gap-x-5">
                            <input type="text" name="tmpt_lahir_jemaat"
                                value="{{ $pengajuan_jemaat->jemaat->tmpt_lahir_jemaat }}"
                                class="w-full p-2 rounded bg-gray-100" disabled>
                            <input type="date" class="w-full p-2 rounded bg-gray-100" disabled
                                name="tgl_lahir_jemaat"
                                value="{{ old('tgl_lahir_jemaat', \Carbon\Carbon::parse($pengajuan_jemaat->jemaat->tgl_lahir_jemaat)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMOR TELEPON</label>
                        <input type="text" name="telp_jemaat" id="telp_jemaat"
                            value="{{ $pengajuan_jemaat->jemaat->telp_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">JENIS KELAMIN</label>
                        <input type="text" name="jk_jemaat" id="jk_jemaat"
                            value="@if ($pengajuan_jemaat->jemaat->jk_jemaat == 'P') Pria @else Wanita @endif"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    w<!-- TODO: tambahin field buat pekerjaan dan wilayah komsel -->
                </div>
            </div>
            <input type="hidden" name="catatan_pengajuan" id="catatan_pengajuan">
            <input type="hidden" name="verifikasi_pengajuan" id="verifikasi_pengajuan">
        </form>
    </div>
    <!-- Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
        <a href="/manajemen/pengajuan">
            <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                BATAL
            </button>
        </a>
        <button type="button" class="bg-red-700  px-6 py-2 rounded-md hover:bg-red-800" onclick="showAlertDecline()">
            TOLAK
        </button>
        <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
            onclick="showAlertVerify()">
            VERIFIKASI
        </button>
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
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Data Diverifikasi",
                        icon: "success",
                        timer: 2000
                    });
                    // Set form values and submit
                    document.getElementById('catatan_pengajuan').value = '';
                    document.getElementById('verifikasi_pengajuan').value = 1;
                    setTimeout(() => {
                        document.getElementById('verifikasiForm').submit();
                    }, 2000); // Wait for the success alert to close
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Diverifikasi", "", "error");
                }
            });
        }
    </script>
    </div>
</x-layout_sistem_informasi>
