{{-- 
TODO: menambahkan cara untuk memverifikasi data yang sudah dibuat oleh bendahara
--}}

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="pembukuanForm" action="{{ route('Pembukuan.update', $pembukuan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PEMBUKUAN</label>
                        <input type="text" name="id_pembukuan" value="{{ $pembukuan->id_pembukuan }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMINAL</label>
                        <input type="text" name="nominal_pembukuan" id="nominal_pembukuan"
                            value="{{ number_format($pembukuan->nominal_pembukuan, 0, ',', ',') }}" autocomplete="off"
                            inputmode="numeric" pattern="[0-9,]*" class="w-full p-2 rounded bg-white" required>
                        <span id="nominal-error" class="text-red-500 text-xs hidden">Hanya angka yang
                            diperbolehkan.</span>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL</label>
                        <input type="date" name="tgl_pembukuan" class="w-full p-2 rounded bg-white"
                            value="{{ \Carbon\Carbon::parse($pembukuan->tgl_pembukuan)->format('Y-m-d') }}"
                            max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TIPE</label>
                        <select name="jenis_pembukuan" class="w-full p-2 rounded bg-white">
                            <option value="Uang Masuk"
                                {{ $pembukuan->jenis_pembukuan == 'Uang Masuk' ? 'selected' : '' }}>
                                Uang Masuk</option>
                            <option value="Uang Keluar"
                                {{ $pembukuan->jenis_pembukuan == 'Uang Keluar' ? 'selected' : '' }}>Uang Keluar
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">DESKRIPSI</label>
                    <textarea class="w-full p-2 rounded bg-white resize-y min-h-[80px] max-h-[50vh]" name="deskripsi_pembukuan"
                        style="height: 120px;">{{ $pembukuan->deskripsi_pembukuan }}</textarea>
                </div>
            </div>

            <!-- Button -->
            <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
                <a href="/pembukuan">
                    <button type="button"
                        class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                        BATAL
                    </button>
                </a>
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                    onclick="showAlertSave()">
                    SIMPAN
                </button>
                <button type="button" class="bg-red-700  px-6 py-2 rounded-md hover:bg-red-800"
                    onclick="showAlertDecline()">
                    TOLAK
                </button>
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                    onclick="showAlertDecline()">
                    VERIFIKASI
                </button>
            </div>
        </form>
    </div>
    </div>

    {{-- untuk ngehilangin koma pas udah submit --}}
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('nominal_pembukuan');
            const error = document.getElementById('nominal-error');
            const form = document.getElementById('pembukuanForm');

            input.addEventListener('input', function(e) {
                // hapus karakter non-digit
                let value = input.value.replace(/[^0-9]/g, '');
                // Format thousand separators
                if (value.length > 0) {
                    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    error.classList.add('hidden');
                } else {
                    input.value = '';
                }
            });

            // Optional: Prevent non-numeric keypresses
            input.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                    error.classList.remove('hidden');
                } else {
                    error.classList.add('hidden');
                }
            });

            // Remove commas before form submission
            form.addEventListener('submit', function() {
                input.value = input.value.replace(/,/g, '');
            });
        });

        function showAlertSave() {
            Swal.fire({
                title: "Simpan perubahan?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove commas before submit
                    Swal.fire("Perubahan diubah", "", "success");
                    const input = document.getElementById('nominal_pembukuan');
                    input.value = input.value.replace(/,/g, '');
                    // Submit the form
                    document.getElementById('pembukuanForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Perubahan tidak diubah", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
