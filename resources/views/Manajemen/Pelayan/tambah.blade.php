<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="pelayanForm" action="{{ route('Manajemen.Pelayan.add') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold text-md mb-4">TAMBAH DATA PELAYAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                    <div>
                        <label class="block font-semibold mb-1">ID PELAYAN</label>
                        <input name="id_pelayan" type="text" value="{{ $id_pelayan }}"
                            class="w-full p-2 rounded bg-gray-100" readonly>
                    </div>
                    <form action="{{ route('Manajemen.Pelayan.search') }}">
                        <div class="relative">
                            <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                            <input type="text" id="nama_jemaat" name="nama_jemaat"
                                class="w-full p-2 rounded bg-white" placeholder="Tambahkan Nama Jemaat"
                                autocomplete="off" required>
                            <div id="jemaat-suggestions"
                                class="absolute z-10 w-full bg-white border mt-1 rounded-md hidden max-h-60 overflow-auto">
                                <!-- Suggestions will appear here -->
                            </div>
                            <!-- Hidden input to store jemaat ID -->
                            <input type="hidden" id="id_jemaat" name="id_jemaat" />
                        </div>
                    </form>
                </div>

                <div x-data="{ hak_akses: '' }">
                    <label class="block font-semibold my-1">HAK AKSES</label>
                    <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak_akses_pelayan" value="Administrator"
                                class="form-radio text-[#215773]" @click="hak_akses = 'Administrator'"
                                :checked="hak_akses === 'Administrator'">
                            <span
                                :class="hak_akses == 'Administrator' ? 'font-semibold' : 'font-normal'">Administrator</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak_akses_pelayan" value="Multimedia"
                                class="form-radio text-[#215773]" @click="hak_akses = 'Multimedia'"
                                :checked="hak_akses === 'Multimedia'">
                            <span :class="hak_akses == 'Multimedia' ? 'font-semibold' : 'font-normal'">Multimedia</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak_akses_pelayan"value="Koordinator"
                                class="form-radio text-[#215773]" <input type="radio" name="hak_akses_pelayan"
                                class="form-radio text-[#215773]" @click="hak_akses = 'Koordinator'"
                                :checked="hak_akses === 'Koordinator'">
                            <span
                                :class="hak_akses == 'Koordinator' ? 'font-semibold' : 'font-normal'">Koordinator</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak_akses_pelayan"value="Praise & Worship"
                                class="form-radio text-[#215773]" <input type="radio" name="hak_akses_pelayan"
                                class="form-radio text-[#215773]" @click="hak_akses = 'Praise & Worship'"
                                :checked="hak_akses === 'Praise & Worship'">
                            <span :class="hak_akses == 'Praise & Worship' ? 'font-semibold' : 'font-normal'">Praise &
                                Worship</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak_akses_pelayan"value="Bendahara"
                                class="form-radio text-[#215773]" <input type="radio" name="hak_akses_pelayan"
                                class="form-radio text-[#215773]" @click="hak_akses = 'Bendahara'"
                                :checked="hak_akses === 'Bendahara'">
                            <span :class="hak_akses == 'Bendahara' ? 'font-semibold' : 'font-normal'">Bendahara</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="hak_akses_pelayan"value="Pelayan Gereja"
                                class="form-radio text-[#215773]" <input type="radio" name="hak_akses_pelayan"
                                class="form-radio text-[#215773]" @click="hak_akses = 'Pelayan Gereja'"
                                :checked="hak_akses === 'Pelayan Gereja'">
                            <span :class="hak_akses == 'Pelayan Gereja' ? 'font-semibold' : 'font-normal'">Pelayan
                                Gereja</span>
                        </label>
                    </div>
                </div>
            </div>
    </div>
    </form>

    <!-- Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
        <a href="/manajemen/pelayan">
            <button class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                BATAL
            </button>
        </a>
        <button
            class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200"
            id="simpanBtn" onclick="showAlertSave()" disabled>
            SIMPAN
        </button>
    </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupSearchableInput({
                inputId: 'nama_jemaat',
                hiddenId: 'id_jemaat',
                suggestionBoxId: 'jemaat-suggestions',
                searchUrl: '/manajemen/pelayan/search', // Adjust to your route
                valueKeys: {
                    id: 'id_jemaat',
                    name: 'nama_jemaat'
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
        });

        // Function to check if all required fields are filled
        function checkRequiredFields() {
            const form = document.getElementById('pelayanForm');
            const requiredFields = form.querySelectorAll('[required]');
            let allFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFilled = false;
                }
            });
            document.getElementById('simpanBtn').disabled = !allFilled;
        }
        // Attach event listeners to required fields
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('pelayanForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
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
                    document.getElementById('pelayanForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Data Baru Tidak Disimpan", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
