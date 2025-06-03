<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="flex-1 bg-white p-10">
        <form id="multimediaForm" action="{{ route('Jadwal.AddPelayan') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold text-md mb-4">TAMBAH DATA PELAYAN MULTIMEDIA</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                    <div>
                        <label class="block font-semibold mb-1">ID JADWAL</label>
                        <input name="id_jadwal" type="text" value="{{ $jadwal->id_jadwal }}"
                            class="w-full p-2 rounded bg-gray-100" readonly>
                    </div>
                    <div class="relative">
                        <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                        <input type="text" id="nama_pelayan" name="nama_pelayan" class="w-full p-2 rounded bg-white"
                            placeholder="Tambahkan Nama Pelayan" autocomplete="off" required>
                        <div id="pelayan-suggestions"
                            class="absolute z-10 w-full bg-white border mt-1 rounded-md hidden max-h-60 overflow-auto">
                            <!-- Suggestions will appear here -->
                        </div>
                        <!-- Hidden input to store pelayan ID -->
                        <input type="hidden" id="id_pelayan" name="id_pelayan" required />
                    </div>
                </div>

                <div x-data="{ peran_pelayan: '' }" class="mt-6">
                    <label class="block font-semibold my-1">PERAN PELAYAN</label>
                    <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="peran_pelayan" value="8" class="form-radio text-[#215773]"
                                @click="peran_pelayan = 'Video'" :checked="peran_pelayan === 'Video'" required>
                            <span :class="peran_pelayan == 'Video' ? 'font-semibold' : 'font-normal'">Video</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="peran_pelayan" value="9" class="form-radio text-[#215773]"
                                @click="peran_pelayan = 'Photo'" :checked="peran_pelayan === 'Photo'">
                            <span :class="peran_pelayan == 'Photo' ? 'font-semibold' : 'font-normal'">Photo</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="peran_pelayan" value="10" class="form-radio text-[#215773]"
                                @click="peran_pelayan = 'Live Stream'" :checked="peran_pelayan === 'Live Stream'">
                            <span :class="peran_pelayan == 'Live Stream' ? 'font-semibold' : 'font-normal'">Live
                                Stream</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="peran_pelayan" value="11" class="form-radio text-[#215773]"
                                @click="peran_pelayan = 'Lyrics'" :checked="peran_pelayan === 'Lyrics'">
                            <span :class="peran_pelayan == 'Lyrics' ? 'font-semibold' : 'font-normal'">Lyrics</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>
        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="/jadwal/multimedia/{{ $jadwal->id_jadwal }}">
                <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
            <button type="button"
                class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200"
                id="simpanBtn" onclick="showAlertSave()" disabled>
                SIMPAN
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupSearchableInput({
                inputId: 'nama_pelayan',
                hiddenId: 'id_pelayan',
                suggestionBoxId: 'pelayan-suggestions',
                searchUrl: '/jadwal/search-multimedia', // Adjust to your route
                valueKeys: {
                    id: 'id_pelayan',
                    name: 'nama_pelayan'
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
                    // Clear hidden input whenever user types
                    hiddenInput.value = '';
                    checkRequiredFields();

                    const query = input.value.trim();
                    const jadwalId = document.querySelector('input[name="id_jadwal"]').value;
                    if (query.length >= 2) {
                        fetch(
                                `${searchUrl}?q=${encodeURIComponent(query)}&jadwal_id=${encodeURIComponent(jadwalId)}`
                            )
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

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!suggestionBox.contains(e.target) && e.target !== input) {
                        suggestionBox.classList.add('hidden');
                    }
                });
            }

            // Function to check if all required fields are filled
            function checkRequiredFields() {
                const form = document.getElementById('multimediaForm');
                // Check all visible required fields
                const requiredFields = form.querySelectorAll('[required]');
                let allFilled = true;
                requiredFields.forEach(field => {
                    // For hidden input, check value directly
                    if (field.type === 'hidden') {
                        if (!field.value.trim()) {
                            allFilled = false;
                        }
                    } else if (field.type === 'radio') {
                        // We'll check radio group separately
                    } else {
                        if (!field.value.trim()) {
                            allFilled = false;
                        }
                    }
                });
                // Specifically check if id_pelayan is filled (i.e., a suggestion was selected)
                const idPelayan = document.getElementById('id_pelayan');
                if (!idPelayan.value.trim()) {
                    allFilled = false;
                }
                // Check if a peran_pelayan radio is selected
                const hakAksesChecked = form.querySelector('input[name="peran_pelayan"]:checked');
                if (!hakAksesChecked) {
                    allFilled = false;
                }
                document.getElementById('simpanBtn').disabled = !allFilled;
            }

            // Attach event listeners to required fields and radios
            const form = document.getElementById('multimediaForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
            });
            // Add event listeners to radio buttons
            const hakAksesRadios = form.querySelectorAll('input[name="peran_pelayan"]');
            hakAksesRadios.forEach(radio => {
                radio.addEventListener('change', checkRequiredFields);
            });
            checkRequiredFields(); // Initial check
        });

        function showAlertSave() {
            Swal.fire({
                title: "Simpan Data?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Data Baru Disimpan", "", "success");
                    // Submit the form
                    document.getElementById('multimediaForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Data Baru Tidak Disimpan", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
