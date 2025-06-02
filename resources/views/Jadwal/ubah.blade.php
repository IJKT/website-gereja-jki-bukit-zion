<!-- TODO: tambahin masalah nama pendeta -->

<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="jadwalForm" action="{{ route('Jadwal.update', $jadwal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">UBAH JADWAL IBADAH</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID JADWAL</label>
                        <input type="text" name="id_jadwal" value="{{ $jadwal->id_jadwal }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL & JAM IBADAH</label>
                        <input type="datetime-local" name="tgl_ibadah"
                            value="{{ \Carbon\Carbon::parse($jadwal->tgl_ibadah)->format('Y-m-d\TH:i') }}"
                            class="w-full p-2 rounded bg-white" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>

                    {{-- PENDETA Suggestion Box --}}
                    {{-- <div class="relative" id="pendeta-suggestion-box">
                        <label class="block font-semibold mb-1">PENDETA</label>
                        <input type="text" id="pendeta-search-input" name="nama_pendeta"
                            class="w-full p-2 rounded bg-white" placeholder="Ketik nama pendeta..."
                            value="{{ old('nama_pendeta', $pendeta->pelayan->jemaat->nama_jemaat ?? '') }}"
                            autocomplete="off" required oninput="searchPendeta()" onfocus="searchPendeta()">
                        <input type="hidden" name="id_pendeta" id="pendeta-id-hidden"
                            value="{{ old('id_pendeta', $pendeta->pelayan->id_pelayan ?? '') }}">
                        <ul id="pendeta-suggestion-list"
                            class="absolute z-10 bg-white border border-gray-300 w-full mt-1 rounded shadow hidden"
                            style="max-height: 200px; overflow-y: auto;"></ul>
                    </div> --}}

                    <div>
                        <label class="block font-semibold mb-1">BACKTRACK</label>
                        @if ($jadwal->backtrack)
                            <input type="file" name="backtrack" id="backtrack" accept=".mp3" class="hidden"
                                onchange="updateBacktrackLabel()">
                            <label for="backtrack" id="backtrack-label"
                                class="w-full p-2 rounded bg-white cursor-pointer block ">
                                {{ $jadwal->backtrack ? \Illuminate\Support\Str::after($jadwal->backtrack, 'backtracks/') : null }}
                            </label>
                            <div class="flex items-center space-x-2 mt-2">
                                <a href="{{ asset('storage/' . $jadwal->backtrack) }}" download
                                    class="px-3 py-1 bg-[#215773] text-white rounded hover:bg-[#1a4a60]">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"
                                        enable-background="new 0 0 32 32" xml:space="preserve"
                                        class="h-5 w-5 font-bold">
                                        <line fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-miterlimit="10" x1="25" y1="28" x2="7"
                                            y2="28" />
                                        <line fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-miterlimit="10" x1="16" y1="23" x2="16"
                                            y2="4" />
                                        <polyline fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-miterlimit="10" points="9,16 16,23 23,16 " />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <input type="file" name="backtrack" id="backtrack" accept=".mp3" class="hidden"
                                onchange="updateBacktrackLabel()">
                            <label for="backtrack" id="backtrack-label"
                                class="w-full p-2 rounded bg-white cursor-pointer block text-gray-500 ">
                                File Backtrack Belum Ditemukan
                            </label>
                        @endif
                    </div>
                </div>
                <div>
                    <label class="block font-semibold my-1">JENIS IBADAH</label>
                    <div class="grid grid-cols-4 gap-x-10 gap-y-4 w-full">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Sunday Service"
                                class="form-radio text-[#215773]"
                                {{ $jadwal->jenis_ibadah === 'Sunday Service' ? 'checked' : '' }} required>
                            <span
                                class="{{ $jadwal->jenis_ibadah == 'Sunday Service' ? 'font-semibold' : 'font-normal' }}">Sunday
                                Service</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Sunday School"
                                class="form-radio text-[#215773]"
                                {{ $jadwal->jenis_ibadah === 'Sunday School' ? 'checked' : '' }}>
                            <span
                                class="{{ $jadwal->jenis_ibadah == 'Sunday School' ? 'font-semibold' : 'font-normal' }}">Sunday
                                School</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Shabbat Fellowship"
                                class="form-radio text-[#215773]"
                                {{ $jadwal->jenis_ibadah === 'Shabbat Fellowship' ? 'checked' : '' }}>
                            <span
                                class="{{ $jadwal->jenis_ibadah == 'Shabbat Fellowship' ? 'font-semibold' : 'font-normal' }}">Shabbat
                                Fellowship</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_ibadah" value="Shabbat Service"
                                class="form-radio text-[#215773]"
                                {{ $jadwal->jenis_ibadah === 'Shabbat Service' ? 'checked' : '' }}>
                            <span
                                class="{{ $jadwal->jenis_ibadah == 'Shabbat Service' ? 'font-semibold' : 'font-normal' }}">Shabbat
                                Service</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="/jadwal">
                <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
            <a href="/jadwal/pujian/{{ $jadwal->id_jadwal }}">
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    PUJIAN
                </button>
            </a>
            <a href="/jadwal/musik/{{ $jadwal->id_jadwal }}">
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    MUSIK
                </button>
            </a>
            <a href="/jadwal/multimedia/{{ $jadwal->id_jadwal }}">
                <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    MULTIMEDIA
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
        // PENDETA suggestion box logic (reference-style, plain JS)
        let pendetaResults = [];
        let pendetaSelectedIndex = -1;

        function searchPendeta() {
            const input = document.getElementById('pendeta-search-input');
            const list = document.getElementById('pendeta-suggestion-list');
            const query = input.value.trim();

            if (query.length < 2) {
                list.innerHTML = '';
                list.classList.add('hidden');
                return;
            }

            fetch(`/jadwal/search-pendeta____)}`)
                .then(response => response.json())
                .then(data => {
                    pendetaResults = data;
                    pendetaSelectedIndex = -1;
                    if (data.length === 0) {
                        list.innerHTML = '<li class="px-4 py-2 text-gray-500">Tidak ditemukan</li>';
                    } else {
                        list.innerHTML = data.map((item, idx) =>
                            `<li class="px-4 py-2 hover:bg-blue-100 cursor-pointer"
                                data-id="${item.id_pelayan}"
                                data-name="${item.nama_jemaat}"
                                onclick="selectPendeta(${idx})"
                                onmouseover="highlightPendeta(${idx})"
                                id="pendeta-suggestion-item-${idx}"
                            >${item.nama_jemaat}</li>`
                        ).join('');
                    }
                    list.classList.remove('hidden');
                });
        }

        function selectPendeta(idx) {
            const input = document.getElementById('pendeta-search-input');
            const hidden = document.getElementById('pendeta-id-hidden');
            if (pendetaResults[idx]) {
                input.value = pendetaResults[idx].nama_jemaat;
                hidden.value = pendetaResults[idx].id_pelayan;
            }
            document.getElementById('pendeta-suggestion-list').classList.add('hidden');
            checkRequiredFields();
        }

        function highlightPendeta(idx) {
            pendetaSelectedIndex = idx;
            const items = document.querySelectorAll('#pendeta-suggestion-list li');
            items.forEach((item, i) => {
                if (i === idx) {
                    item.classList.add('bg-blue-100');
                } else {
                    item.classList.remove('bg-blue-100');
                }
            });
        }

        // Keyboard navigation for suggestion box
        document.getElementById('pendeta-search-input').addEventListener('keydown', function(e) {
            const list = document.getElementById('pendeta-suggestion-list');
            const items = list.querySelectorAll('li');
            if (list.classList.contains('hidden') || items.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                pendetaSelectedIndex = (pendetaSelectedIndex + 1) % items.length;
                highlightPendeta(pendetaSelectedIndex);
                items[pendetaSelectedIndex].scrollIntoView({
                    block: 'nearest'
                });
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                pendetaSelectedIndex = (pendetaSelectedIndex - 1 + items.length) % items.length;
                highlightPendeta(pendetaSelectedIndex);
                items[pendetaSelectedIndex].scrollIntoView({
                    block: 'nearest'
                });
            } else if (e.key === 'Enter') {
                if (pendetaSelectedIndex >= 0 && pendetaResults[pendetaSelectedIndex]) {
                    e.preventDefault();
                    selectPendeta(pendetaSelectedIndex);
                }
            }
        });

        // Hide suggestion list when clicking outside
        document.addEventListener('mousedown', function(event) {
            const box = document.getElementById('pendeta-suggestion-box');
            if (!box.contains(event.target)) {
                document.getElementById('pendeta-suggestion-list').classList.add('hidden');
            }
        });

        // Backtrack label update
        function updateBacktrackLabel() {
            const input = document.getElementById('backtrack');
            const label = document.getElementById('backtrack-label');
            if (input.files && input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.classList.remove('text-gray-500');
                label.classList.add('text-black');
            } else {
                label.textContent = 'File Backtrack Belum Ditemukan';
                label.classList.remove('text-black');
                label.classList.add('text-gray-500');
            }
        }

        // Required fields checker (including radio group)
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
                    // handled below
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

        // SweetAlert confirmation for save
        function showAlertSave() {
            Swal.fire({
                title: "Simpan perubahan?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Perubahan diubah", "", "success");
                    document.getElementById('jadwalForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Perubahan tidak diubah", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
