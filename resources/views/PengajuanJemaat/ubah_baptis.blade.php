<!-- TODO: buat biar simpan buttonnya dihilangkan kalau sudah diverifikasi datanya-->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="pengajuanForm" action="{{ route('PengajuanJemaat.update_baptis', $baptis) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">UBAH DATA BAPTIS</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PENGAJUAN</label>
                        <input type="text" name="id_jadwal" value="{{ $baptis->id_baptis }}"
                            class="w-full p-2 rounded bg-gray-100" readonly>
                    </div>
                    <div class="relative">
                        <label class="block font-semibold mb-1">PENGAJAR KELAS BAPTIS</label>
                        <input type="text" id="nama_pengajar" value="{{ $baptis->pengajar->jemaat->nama_jemaat }}"
                            name="nama_pengajar" class="w-full p-2 rounded bg-white" autocomplete="off" required>
                        <div id="pengajar_suggestions"
                            class="absolute z-10 w-full bg-white border mt-1 rounded-md hidden max-h-60 overflow-auto">
                            <!-- Suggestions will appear here -->
                        </div>
                        <!-- Hidden input to store pelayan ID -->
                        <input type="hidden" id="id_pelayan" value="{{ $baptis->id_pengajar }}" name="id_pelayan"
                            required />
                    </div>
                    <div>
                        <label class="block font-semibold my-1">PREFERENSI NAMA</label>
                        <select name="preferensi_nama" class="w-full p-2 rounded bg-white">
                            <option value="">Tidak Ada Preferensi</option>
                            <option value="Bahasa Indonesia" @if ($baptis->preferensi_nama_baptis == 'Bahasa Indonesia') selected @endif>Bahasa
                                Indonesia</option>
                            <option value="Bahasa Inggris" @if ($baptis->preferensi_nama_baptis == 'Bahasa Inggris') selected @endif>Bahasa
                                Inggris</option>
                            <option value="Bahasa Ibrani" @if ($baptis->preferensi_nama_baptis == 'Bahasa Ibrani') selected @endif>Bahasa
                                Ibrani</option>
                            <option value="Bahasa Yunani" @if ($baptis->preferensi_nama_baptis == 'Bahasa Yunani') selected @endif>Bahasa
                                Yunani</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
        <a href="{{ route('PengajuanJemaat.baptis') }}">
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
            const form = document.getElementById('pengajuanForm');
            const simpanBtn = document.getElementById('simpanBtn');

            // Autocomplete Nama Pendeta
            setupSearchableInput({
                inputId: 'nama_pengajar',
                hiddenId: 'id_pelayan',
                suggestionBoxId: 'pengajar_suggestions',
                searchUrl: '{{ route('PengajuanJemaat.search_pengajar') }}',
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

            function checkRequiredFields() {
                const requiredFields = form.querySelectorAll('[required]');
                let allFilled = true;

                requiredFields.forEach(field => {
                    if (field.type === 'file') {
                        if (field.files.length === 0) {
                            allFilled = false;
                        }
                    } else {
                        // Skip checking 'preferensi_nama' even if it's empty
                        if (!field.value.trim() && field.name !== 'preferensi_nama') {
                            allFilled = false;
                        }
                    }
                });

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

            checkRequiredFields(); // Awal

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
