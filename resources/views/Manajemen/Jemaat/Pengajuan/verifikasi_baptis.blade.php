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
                        <input type="text" value="{{ $pengajuan_jemaat->id_baptis }}"
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
                        <label class="block font-semibold mb-1">PEKERJAAN</label>
                        <input type="text" value="{{ $pengajuan_jemaat->jemaat->pekerjaan_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" placeholder="Belum/Tidak Bekerja" disabled>
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
                        <input type="text" value="{{ $pengajuan_jemaat->preferensi_nama_baptis }}"
                            class="w-full p-2 rounded bg-gray-100" disabled placeholder="Tidak Ada Preferensi">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">PENGAJAR KELAS BAPTIS</label>
                        <input type="text" value="{{ $pengajuan_jemaat->pengajar->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                </div>
                {{-- untuk mendapatkan hidden input --}}
                <input type="hidden" name="catatan_pengajuan" id="catatan_pengajuan">
                <input type="hidden" name="verifikasi_pengajuan" id="verifikasi_pengajuan">
                <input type="hidden" name="tgl_baptis" id="tgl_baptis">
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
                    // document.getElementById('verifikasiForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Ditolak", "", "error");
                }
            });
        }

        // TODO: nanti tambahin date'nya di controller
        function showAlertVerify() {
            Swal.fire({
                title: "Verifikasi Data?",
                input: 'date',
                inputLabel: 'Tanggal Baptis',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Tanggal baptis harus diisi!';
                    }
                    // Optional: Prevent selecting a past date
                    const today = new Date();
                    const selected = new Date(value);
                    today.setHours(0, 0, 0, 0);
                    if (selected < today) {
                        return 'Tanggal baptis tidak boleh di masa lalu!';
                    }
                    return null;
                },
                // Optional: Set min date to today
                didOpen: () => {
                    const input = Swal.getInput();
                    if (input) {
                        const today = new Date();
                        const yyyy = today.getFullYear();
                        const mm = String(today.getMonth() + 1).padStart(2, '0');
                        const dd = String(today.getDate()).padStart(2, '0');
                        input.min = `${yyyy}-${mm}-${dd}`;
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const tgl_baptis = result.value;
                    const date = new Date(tgl_baptis);
                    const tanggal_baptis = date.toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    Swal.fire({
                        title: "Data Diverifikasi",
                        text: "Jemaat akan dibaptis pada " + tanggal_baptis,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    // Set form values and submit
                    document.getElementById('catatan_pengajuan').value = '';
                    document.getElementById('tgl_baptis').value = tgl_baptis;
                    document.getElementById('verifikasi_pengajuan').value = 1;
                    setTimeout(() => {
                        // document.getElementById('verifikasiForm').submit();
                    }, 2000); // Wait for the success alert to close
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Diverifikasi", "", "error");
                }
                // If dismissed or cancelled, do nothing
            });
        }
    </script>
</x-layout_sistem_informasi>
