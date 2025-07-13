<!-- TODO: buat field untuk detail pemasukan-->
<!-- TODO: buat field untuk detail pengeluaran -> apakah perlu?-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="pembukuanForm" action="{{ route('Pembukuan.update', $pembukuan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">UBAH DATA PEMBUKUAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2" x-data="{ tipe: '{{ $pembukuan->jenis_pembukuan }}' }">
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
                            max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TIPE</label>
                        <select name="jenis_pembukuan" class="w-full p-2 rounded bg-white" x-model="tipe">
                            <option value="Uang Masuk"
                                {{ $pembukuan->jenis_pembukuan == 'Uang Masuk' ? 'selected' : '' }}>
                                Uang Masuk</option>
                            <option value="Uang Keluar"
                                {{ $pembukuan->jenis_pembukuan == 'Uang Keluar' ? 'selected' : '' }}>Uang Keluar
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1" :class="tipe ? 'required' : ''">KATEGORI UANG
                            MASUK</label>
                        <select name="jenis_pemasukan" id="jenis_pemasukan"
                            class="w-full p-2 rounded bg-white disabled:bg-gray-100" :disabled="tipe !== 'Uang Masuk'"
                            :required="tipe === 'Uang Masuk'">
                            <option value="Persembahan Ibadah Raya"
                                {{ $pembukuan->jenis_pemasukan == 'Persembahan Ibadah Raya' ? 'selected' : '' }}>
                                Persembahan Ibadah Raya</option>
                            <option value="Persembahan Perpuluhan"
                                {{ $pembukuan->jenis_pemasukan == 'Persembahan Perpuluhan' ? 'selected' : '' }}>
                                Persembahan Perpuluhan</option>
                            <option value="Persembahan Misi"
                                {{ $pembukuan->jenis_pemasukan == 'Persembahan Misi' ? 'selected' : '' }}>
                                Persembahan Misi</option>
                            <option value="Persembahan Outreach"
                                {{ $pembukuan->jenis_pemasukan == 'Persembahan Outreach' ? 'selected' : '' }}>
                                Persembahan Outreach</option>
                            <option value="Persembahan Rumah Asuhan"
                                {{ $pembukuan->jenis_pemasukan == 'Persembahan Rumah Asuhan' ? 'selected' : '' }}>
                                Persembahan Rumah Asuhan</option>
                            <option value="Persembahan Donasi"
                                {{ $pembukuan->jenis_pemasukan == 'Persembahan Donasi' ? 'selected' : '' }}>
                                Persembahan Donasi</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">DESKRIPSI</label>
                    <textarea class="w-full p-2 rounded bg-white resize-y min-h-[80px] max-h-[50vh]" name="deskripsi_pembukuan"
                        style="height: 120px;" required>{{ $pembukuan->deskripsi_pembukuan }}</textarea>
                </div>
            </div>
        </form>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button type="button" id="simpanBtn" onclick="showAlertSave()" disabled
                class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
                SIMPAN
            </button>
            <a href="{{ route('Pembukuan.viewall') }}">
                <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
        </div>
    </div>
    </div>

    {{-- untuk ngehilangin koma pas udah submit --}}
    @stack('scripts')
    <script>
        // Function to check if all required fields are filled
        function checkRequiredFields() {
            const form = document.getElementById('pembukuanForm');
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

        // Attach event listeners to required fields
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('pembukuanForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
            });
            checkRequiredFields(); // Initial check
        });

        function showAlertSave() {
            Swal.fire({
                title: "Simpan Perubahan Data?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove commas before submit
                    Swal.fire("Perubahan Disimpan", "", "success");
                    const input = document.getElementById('nominal_pembukuan');
                    input.value = input.value.replace(/,/g, '');
                    // Submit the form
                    setTimeout(() => {
                        document.getElementById('pembukuanForm').submit();
                    }, 1000); // Wait for 1 seconds
                } else if (result.isDenied) {
                    Swal.fire("Perubahan Tidak Disimpan", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
