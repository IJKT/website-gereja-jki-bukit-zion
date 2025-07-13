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
                    <div class="relative">
                        <label class="block font-semibold mb-1">NAMA PENDETA</label>
                        <input type="text" id="nama_pendeta" name="nama_pendeta" class="w-full p-2 rounded bg-white"
                            placeholder="Tambahkan Nama Pendeta" autocomplete="off" required>
                        <div id="pendeta-suggestions"
                            class="absolute z-10 w-full bg-white border mt-1 rounded-md hidden max-h-60 overflow-auto">
                            <!-- Suggestions will appear here -->
                        </div>
                        <!-- Hidden input to store pelayan ID -->
                        <input type="hidden" id="id_pelayan" name="id_pelayan" />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">BACKTRACK</label>
                        <div class="relative">
                            <input type="file" name="backtrack" id="backtrack" accept=".mp3" class="hidden"
                                onchange="updateBacktrackLabel()">
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
                                class="form-radio text-[#215773]" @click="jenis_ibadah = 'Shabbat Fellowship'"
                                :checked="jenis_ibadah === 'Shabbat Fellowship'">
                            <span
                                :class="jenis_ibadah == 'Shabbat Fellowship' ? 'font-semibold' : 'font-normal'">Shabbat
                                Fellowship</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Shabbat Service"
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
        <button type="button" id="simpanBtn" onclick="showAlertSave()" disabled
            class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
            SIMPAN
        </button>
        <a href="{{ route('Jadwal.viewall') }}">
            <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                BATAL
            </button>
        </a>
    </div>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jadwalForm');
            const simpanBtn = document.getElementById('simpanBtn');

            // Autocomplete Nama Pendeta
            setupSearchableInput({
                inputId: 'nama_pendeta',
                hiddenId: 'id_pelayan',
                suggestionBoxId: 'pendeta-suggestions',
                searchUrl: '{{ route('Jadwal.search-pendeta') }}',
                valueKeys: {
                    id: 'id_pelayan',
                    name: 'nama_pendeta'
                }
            });

            function setupSearchableInput({
                inputId,
                hiddenId,
                suggestionBoxId,
                searchUrl,
                valueKeys
            }) {
                const input = document.getElementById(inputId);
                const hiddenInput = document.getElementById(hiddenId);
                const suggestionBox = document.getElementById(suggestionBoxId);

                input.addEventListener('input', function() {
                    hiddenInput.value = '';
                    checkRequiredFields();

                    const query = input.value.trim();
                    if (query.length >= 2) {
                        fetch(`${searchUrl}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    suggestionBox.innerHTML = data.map(item => `
                                    <div class="px-3 py-2 cursor-pointer hover:bg-gray-100"
                                        data-id="${item[valueKeys.id]}"
                                        data-name="${item[valueKeys.name]}">
                                        ${item[valueKeys.name]} (${item[valueKeys.id]})
                                    </div>
                                `).join('');
                                    suggestionBox.classList.remove('hidden');
                                    addSuggestionClickListeners();
                                } else {
                                    suggestionBox.classList.add('hidden');
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching suggestions:', error);
                                suggestionBox.classList.add('hidden');
                            });
                    } else {
                        suggestionBox.classList.add('hidden');
                    }
                });

                function addSuggestionClickListeners() {
                    const items = suggestionBox.querySelectorAll('div');
                    items.forEach(item => {
                        item.addEventListener('click', function() {
                            input.value = item.getAttribute('data-name');
                            hiddenInput.value = item.getAttribute('data-id');
                            suggestionBox.classList.add('hidden');
                            checkRequiredFields();
                        });
                    });
                }

                document.addEventListener('click', function(e) {
                    if (!suggestionBox.contains(e.target) && e.target !== input) {
                        suggestionBox.classList.add('hidden');
                    }
                });
            }

            // Cek semua isian wajib
            function checkRequiredFields() {
                const requiredFields = form.querySelectorAll('[required]');
                let allFilled = true;

                requiredFields.forEach(field => {
                    if (field.type === 'file') {
                        if (field.files.length === 0) {
                            allFilled = false;
                        }
                    } else if (field.type === 'radio') {
                        // Radio akan dicek di bawah
                    } else {
                        if (!field.value.trim()) {
                            allFilled = false;
                        }
                    }
                });

                const jenisIbadahChecked = form.querySelector('input[name="jenis_ibadah"]:checked');
                if (!jenisIbadahChecked) {
                    allFilled = false;
                }

                simpanBtn.disabled = !allFilled;
            }

            // Pasang listener ke semua field wajib
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (field.type === 'file') {
                    field.addEventListener('change', checkRequiredFields);
                } else {
                    field.addEventListener('input', checkRequiredFields);
                }
            });

            const jenisIbadahRadios = form.querySelectorAll('input[name="jenis_ibadah"]');
            jenisIbadahRadios.forEach(radio => {
                radio.addEventListener('change', checkRequiredFields);
            });

            checkRequiredFields(); // Awal

            // Update label file input
            window.updateBacktrackLabel = function() {
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

                checkRequiredFields(); // Recheck on file change
            };

            // Konfirmasi sebelum simpan
            window.showAlertSave = function() {
                Swal.fire({
                    title: "Simpan Data Baru?",
                    icon: 'warning',
                    showDenyButton: true,
                    confirmButtonText: "Simpan",
                    denyButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire("Data Baru Disimpan", "", "success");
                        setTimeout(() => {
                            form.submit();
                        }, 1000); // Wait for 1 seconds
                    } else if (result.isDenied) {
                        Swal.fire("Data Baru Tidak Disimpan", "", "error");
                    }
                });
            };
        });
    </script>

</x-layout_sistem_informasi>
