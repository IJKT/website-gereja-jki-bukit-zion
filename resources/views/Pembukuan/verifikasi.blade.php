<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="pembukuanForm" action="{{ route('Pembukuan.verify', $pembukuan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">VERIFIKASI DATA PEMBUKUAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PEMBUKUAN</label>
                        <input type="text" name="id_pembukuan" value="{{ $pembukuan->id_pembukuan }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMINAL</label>
                        <input type="text" name="nominal_pembukuan" id="nominal_pembukuan"
                            value="{{ number_format($pembukuan->nominal_pembukuan, 0, ',', ',') }}" inputmode="numeric"
                            pattern="[0-9,]*" class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL</label>
                        <input type="date" name="tgl_pembukuan" class="w-full p-2 rounded bg-gray-100" disabled
                            value="{{ \Carbon\Carbon::parse($pembukuan->tgl_pembukuan)->Format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TIPE</label>
                        <input type="text" name="jenis_pembukuan" value="{{ $pembukuan->jenis_pembukuan }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">DESKRIPSI</label>
                    <textarea class="w-full p-2 rounded bg-gray-100 resize-y min-h-[80px] max-h-[50vh]" name="deskripsi_pembukuan"
                        style="height: 120px;" disabled>{{ $pembukuan->deskripsi_pembukuan }}</textarea>
                </div>
            </div>

            <!-- Button -->
            <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
                <a href="{{ route('Pembukuan.viewall') }}">
                    <button type="button"
                        class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
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

            {{-- untuk mendapatkan komentar dan verifikasi --}}
            <input type="hidden" name="catatan_pembukuan" id="catatan_pembukuan">
            <input type="hidden" name="verifikasi_pembukuan" id="verifikasi_pembukuan">
        </form>
    </div>
    </div>

    {{-- untuk ngehilangin koma pas udah submit --}}
    @stack('scripts')
    <script>
        function showAlertDecline() {
            Swal.fire({
                title: "Tolak verifikasi?",
                input: 'text',
                inputLabel: 'Alasan penolakan',
                inputPlaceholder: 'Masukkan catatan penolakan',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const catatan_pembukuan = result.value;
                    Swal.fire("Data Ditolak", "Catatan: " + catatan_pembukuan, "success");
                    // Submit the form
                    document.getElementById('catatan_pembukuan').value = catatan_pembukuan;
                    document.getElementById('verifikasi_pembukuan').value = 2;
                    document.getElementById('pembukuanForm').submit();
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
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Data Diverifikasi", "", "success");
                    // Submit the form
                    document.getElementById('catatan_pembukuan').value = null;
                    document.getElementById('verifikasi_pembukuan').value = 1;
                    document.getElementById('pembukuanForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Diverifikasi", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
