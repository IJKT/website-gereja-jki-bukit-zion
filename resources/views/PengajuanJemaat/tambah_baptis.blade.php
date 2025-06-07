<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        {{-- <form id="jadwalForm" action="{{ route('Jadwal.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') --}}
        <div class="bg-gray-200 p-6 rounded-md">
            <h2 class="font-bold mb-4">TAMBAH DATA BAPTIS</h2>
            <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                <div>
                    <label class="block font-semibold mb-1">ID PENGAJUAN</label>
                    <input type="text" name="id_jadwal" value="{{ $id_baptis }}"
                        class="w-full p-2 rounded bg-gray-100" readonly>
                </div>
                <div class="relative">
                    <label class="block font-semibold mb-1">PENGAJAR KELAS BAPTIS</label>
                    <input type="text" id="nama_pengajar" name="nama_pengajar" class="w-full p-2 rounded bg-white"
                        placeholder="Tambahkan Nama Pengajar Kelas Pembaptis" autocomplete="off" required>
                    <div id="pengajar_suggestions"
                        class="absolute z-10 w-full bg-white border mt-1 rounded-md hidden max-h-60 overflow-auto">
                        <!-- Suggestions will appear here -->
                    </div>
                    <!-- Hidden input to store pelayan ID -->
                    <input type="hidden" id="id_pelayan" name="id_pelayan" />
                </div>
            </div>
            <!--TODO: buat ini jadi dropdown aja-->
            <div x-data="{ preferensi_nama: '' }">
                <label class="block font-semibold my-1">JENIS IBADAH</label>
                <div class="grid grid-cols-4 gap-x-10 gap-y-4 w-full">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="preferensi_nama" value="Bahasa Indonesia"
                            class="form-radio text-[#215773]" @click="preferensi_nama = 'Bahasa Indonesia'"
                            :checked="preferensi_nama === 'Bahasa Indonesia'" required>
                        <span :class="preferensi_nama == 'Bahasa Indonesia' ? 'font-semibold' : 'font-normal'">Bahasa
                            Indonesia</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="preferensi_nama" value="Bahasa Inggris"
                            class="form-radio text-[#215773]" @click="preferensi_nama = 'Bahasa Inggris'"
                            :checked="preferensi_nama === 'Bahasa Inggris'">
                        <span :class="preferensi_nama == 'Bahasa Inggris' ? 'font-semibold' : 'font-normal'">Bahasa
                            Inggris</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="preferensi_nama" value="Bahasa Ibrani"
                            class="form-radio text-[#215773]" @click="preferensi_nama = 'Bahasa Ibrani'"
                            :checked="preferensi_nama === 'Bahasa Ibrani'">
                        <span :class="preferensi_nama == 'Bahasa Ibrani' ? 'font-semibold' : 'font-normal'">Bahasa
                            Ibrani</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="preferensi_nama" value="Bahasa Yunani"
                            class="form-radio text-[#215773]" @click="preferensi_nama = 'Bahasa Yunani'"
                            :checked="preferensi_nama === 'Bahasa Yunani'">
                        <span :class="preferensi_nama == 'Bahasa Yunani' ? 'font-semibold' : 'font-normal'">Bahasa
                            Yunani</span>
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

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jadwalForm');
            const simpanBtn = document.getElementById('simpanBtn');

            // Autocomplete Nama Pendeta
            setupSearchableInput({
                inputId: 'nama_pengajar',
                hiddenId: 'id_pelayan',
                suggestionBoxId: 'pengajar_suggestions',
                searchUrl: '/jadwal/search-pendeta',
                valueKeys: {
                    id: 'id_pelayan',
                    name: 'nama_pengajar'
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

                const jenisIbadahChecked = form.querySelector('input[name="preferensi_nama"]:checked');
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

            const jenisIbadahRadios = form.querySelectorAll('input[name="preferensi_nama"]');
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
                    title: "Simpan perubahan?",
                    icon: 'warning',
                    showDenyButton: true,
                    confirmButtonText: "Simpan",
                    denyButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire("Perubahan disimpan", "", "success");
                        form.submit();
                    } else if (result.isDenied) {
                        Swal.fire("Perubahan tidak disimpan", "", "info");
                    }
                });
            };
        });
    </script>

</x-layout_sistem_informasi>
