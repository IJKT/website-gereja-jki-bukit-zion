<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="jadwalForm" action="{{ route('Jadwal.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">TAMBAH JADWAL IBADAH</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID JADWAL</label>
                        <input type="text" name="id_jadwal" value="{{ $id_jadwal }}"
                            class="w-full p-2 rounded bg-gray-100" readonly>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL & JAM IBADAH</label>
                        <input type="datetime-local" name="tgl_ibadah" class="w-full p-2 rounded bg-white"
                            min="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">BACKTRACK</label>
                        <div class="relative">
                            <input type="file" name="backtrack" id="backtrack" accept=".mp3" class="hidden"
                                onchange="updateBacktrackLabel()" required>
                            <label for="backtrack" id="backtrack-label"
                                class="w-full p-2 rounded bg-white cursor-pointer block text-gray-500 ">
                                File Backtrack Belum Ditemukan
                            </label>
                        </div>
                        <span id="backtrack-filename" class="block text-sm text-gray-700 mt-1"></span>
                    </div>
                </div>
                <div x-data="{ jenis_ibadah: '' }">
                    <label class="block font-semibold my-1">JENIS IBADAH</label>
                    <div class="grid grid-cols-4 gap-x-10 gap-y-4 w-full">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Sunday Service"
                                class="form-radio text-[#215773]" @click="jenis_ibadah = 'Sunday Service'"
                                :checked="jenis_ibadah === 'Sunday Service'" required>
                            <span :class="jenis_ibadah == 'Sunday Service' ? 'font-semibold' : 'font-normal'">Sunday
                                Service</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Sunday School"
                                class="form-radio text-[#215773]" @click="jenis_ibadah = 'Sunday School'"
                                :checked="jenis_ibadah === 'Sunday School'">
                            <span :class="jenis_ibadah == 'Sunday School' ? 'font-semibold' : 'font-normal'">Sunday
                                School</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Shabbat Fellowship"
                                class="form-radio text-[#215773]" <input type="radio" name="hak_akses_pelayan"
                                class="form-radio text-[#215773]" @click="jenis_ibadah = 'Shabbat Fellowship'"
                                :checked="jenis_ibadah === 'Shabbat Fellowship'">
                            <span
                                :class="jenis_ibadah == 'Shabbat Fellowship' ? 'font-semibold' : 'font-normal'">Shabbat
                                Fellowship</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Shabbat Service"
                                class="form-radio text-[#215773]" <input type="radio" name="hak_akses_pelayan"
                                class="form-radio text-[#215773]" @click="jenis_ibadah = 'Shabbat Service'"
                                :checked="jenis_ibadah === 'Shabbat Service'">
                            <span :class="jenis_ibadah == 'Shabbat Service' ? 'font-semibold' : 'font-normal'">Shabbat
                                Service</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
        <a href="/jadwal">
            <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                BATAL
            </button>
        </a>
        <button type="button" id="simpanBtn" onclick="showAlertSave()" disabled
            class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
            SIMPAN
        </button>
    </div>
    </div>

    {{-- untuk ngehilangin koma pas udah submit --}}
    @stack('scripts')
    <script>
        // Function to check if all required fields are filled
        function checkRequiredFields() {
            const form = document.getElementById('jadwalForm');
            const requiredFields = form.querySelectorAll('[required]');
            let allFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFilled = false;
                }
            });
            document.getElementById('simpanBtn').disabled = !allFilled;
        }

        function checkRequiredFields() {
            const form = document.getElementById('jadwalForm');
            const requiredFields = form.querySelectorAll('[required]');
            let allFilled = true;

            requiredFields.forEach(field => {
                if (field.type === 'file') {
                    if (field.files.length === 0) {
                        allFilled = false;
                    }
                } else if (field.type === 'radio') {
                    // di handle di radio group
                } else {
                    if (!field.value.trim()) {
                        allFilled = false;
                    }
                }
            });

            // Check if a radio button in the 'jenis_ibadah' group is selected
            const jenisIbadahChecked = form.querySelector('input[name="jenis_ibadah"]:checked');
            if (!jenisIbadahChecked) {
                allFilled = false;
            }

            document.getElementById('simpanBtn').disabled = !allFilled;
        }


        // Attach event listeners to required fields and radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jadwalForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (field.type === 'file') {
                    field.addEventListener('change', checkRequiredFields);
                } else {
                    field.addEventListener('input', checkRequiredFields);
                }
            });
            // Add event listeners to radio buttons for 'jenis_ibadah'
            const jenisIbadahRadios = form.querySelectorAll('input[name="jenis_ibadah"]');
            jenisIbadahRadios.forEach(radio => {
                radio.addEventListener('change', checkRequiredFields);
            });
            checkRequiredFields(); // Initial check
        });

        function updateBacktrackLabel() {
            const input = document.getElementById('backtrack');
            const label = document.getElementById('backtrack-label');
            const filenameSpan = document.getElementById('backtrack-filename');
            if (input.files && input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.classList.remove('text-gray-500');
                label.classList.add('text-black');
            } else {
                filenameSpan.textContent = '';
                label.textContent = 'File Backtrack Belum Ditemukan';
                label.classList.remove('text-black');
                label.classList.add('text-gray-500');
            }
        }

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
                    // Submit the form
                    document.getElementById('jadwalForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Perubahan tidak diubah", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
