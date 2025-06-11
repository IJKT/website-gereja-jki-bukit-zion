<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="pengajuanForm" action="{{ route('PengajuanJemaat.update_pernikahan', $pernikahan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">TAMBAH DATA PERNIKAHAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PENGAJUAN</label>
                        <input type="text" name="id_jadwal" value="{{ $pernikahan->id_pernikahan }}"
                            class="w-full p-2 rounded bg-gray-100" readonly>
                    </div>
                    <div class="relative">
                        <label class="block font-semibold mb-1">CALON PASANGAN</label>
                        <input type="text" id="nama_pasangan" name="nama_pasangan"
                            class="w-full p-2 rounded bg-white" placeholder="Tambahkan Nama Calon Pasangan"
                            autocomplete="off"
                            value="@if (Auth::user()->jemaat->jk_jemaat == 'P') {{ $pernikahan->jemaat_wanita->nama_jemaat }}@else{{ $pernikahan->jemaat_pria->nama_jemaat }} @endif"
                            required>
                        <div id="pasangan_suggestions"
                            class="absolute z-10 w-full bg-white
                            border mt-1 rounded-md hidden max-h-60 overflow-auto">
                            <!-- Suggestions will appear here -->
                        </div>
                        <!-- Hidden input to store jemaat ID -->
                        <input type="hidden" id="id_jemaat" name="id_jemaat"
                            value="@if (Auth::user()->jemaat->jk_jemaat == 'P') {{ $pernikahan->id_jemaat_w }}@else{{ $pernikahan->id_jemaat_p }} @endif"
                            required />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TEMPAT PERNIKAHAN</label>
                        <input type="text" name="tempat_pernikahan" class="w-full p-2 rounded bg-white"
                            placeholder="Tambahkan Tempat Pernikahan" autocomplete="off"
                            value="{{ $pernikahan->tempat_pernikahan }}" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL & JAM PERNIKAHAN</label>
                        <input type="datetime-local" name="tanggal_jam_pernikahan" class="w-full p-2 rounded bg-white"
                            placeholder="Tambahkan tanggal Pernikahan"
                            value="{{ \Carbon\Carbon::parse($pernikahan->tgl_pernikahan)->format('Y-m-d\TH:i') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
        <a href="{{ route('PengajuanJemaat.pernikahan') }}">
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
        const jk_user = '{{ auth()->user()->jemaat->jk_jemaat }}';

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('pengajuanForm');
            const simpanBtn = document.getElementById('simpanBtn');

            // Autocomplete Nama Pasangan
            setupSearchableInput({
                inputId: 'nama_pasangan',
                hiddenId: 'id_jemaat',
                suggestionBoxId: 'pasangan_suggestions',
                searchUrl: '{{ route('PengajuanJemaat.search_pasangan') }}',
                valueKeys: {
                    id: 'id_jemaat',
                    name: 'nama_pasangan'
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
                        fetch(`${searchUrl}?q=${encodeURIComponent(query)}&exclude_gender=${jk_user}`)
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
