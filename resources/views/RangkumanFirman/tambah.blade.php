<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="rangkumanForm" action="{{ route('RangkumanFirman.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">TAMBAH RANGKUMAN FIRMAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2" x-data="{ tipe_rangkuman: '', kategoriSermonsRequired: false }" x-init="$watch('tipe_rangkuman', value => {
                    kategoriSermonsRequired = (value === 'Sermons');
                })">
                    <div>
                        <label class="block font-semibold mb-1">ID RANGKUMAN</label>
                        <input type="text" name="id_rangkuman" value="{{ $id_rangkuman }}"
                            class="w-full p-2 rounded bg-gray-100" readonly>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NAMA NARASUMBER</label>
                        <input type="text" name="nama_narasumber" autocomplete="off"
                            placeholder="Masukkan Nama Narasumber" class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">JUDUL RANGKUMAN</label>
                        <input type="text" name="judul_rangkuman" autocomplete="off"
                            placeholder="Masukkan Judul Rangkuman" class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">GAMBAR RANGKUMAN</label>
                        <div class="relative">
                            <input type="file" name="gambar_rangkuman" id="gambar_rangkuman"
                                accept=".jpg, .jpeg, .png .webp" class="hidden" onchange="updateGambarLabel()">
                            <label for="gambar_rangkuman" id="gambar_rangkuman-label"
                                class="w-full p-2 rounded bg-white cursor-pointer block text-gray-500 ">
                                File Gambar Belum Ditemukan
                            </label>
                        </div>
                        <span id="gambar_rangkuman-filename" class="block text-sm text-gray-700 mt-1"></span>
                    </div>
                    <div class="mb-4">
                        <label class="font-semibold block mb-4">TIPE RANGKUMAN</label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="tipe_rangkuman" @click="tipe_rangkuman = 'Sermons'"
                                    @click="kategoriSermonsRequired = true" class="form-radio text-[#215773]"
                                    value="Sermons" required>
                                <span
                                    :class="tipe_rangkuman == 'Sermons' ? 'font-semibold' : 'font-normal'">Sermons</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="tipe_rangkuman" @click="tipe_rangkuman = 'Articles'"
                                    value="Articles" class="form-radio text-[#215773]" required>
                                <span
                                    :class="tipe_rangkuman == 'Articles' ? 'font-semibold' : 'font-normal'">Articles</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="tipe_rangkuman" @click="tipe_rangkuman = 'Devotions'"
                                    value="Devotions" class="form-radio text-[#215773]" required>
                                <span
                                    :class="tipe_rangkuman == 'Devotions' ? 'font-semibold' : 'font-normal'">Devotions</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="hak-akses" class="block font-semibold mb-1"
                            :class="kategoriSermonsRequired ? 'required' : ''">KATEGORI SERMON</label>
                        <select name="kategori_sermons" id="kategori_sermons"
                            class="w-full p-2 rounded bg-white disabled:bg-gray-100"
                            :disabled="!kategoriSermonsRequired" :required="kategoriSermonsRequired">
                            <option value="Sunday Service">Sunday Service</option>
                            <option value="Shabbat Fellowship">Shabbat Fellowship</option>
                        </select>
                    </div>
                </div>

                {{-- @trixassets --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-4">ISI RANGKUMAN</label>
                    <input id="isi_rangkuman" type="hidden" name="isi_rangkuman" required>
                    <trix-editor input="isi_rangkuman" class="trix-content bg-white p-2 rounded-md"
                        placeholder="Masukkan Isi Rangkuman"></trix-editor>
                </div>
            </div>
        </form>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button type="button" id="simpanBtn" onclick="showAlertSave()" disabled
                class="bg-[#215773] px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
                SIMPAN
            </button>
            <a href="{{ route('RangkumanFirman.viewall') }}">
                <button type="button" class="text-[#215773] px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
        </div>
    </div>

    {{-- untuk ngehilangin koma pas udah submit --}}
    @stack('scripts')
    <script>
        window.updateGambarLabel = function() {
            const input = document.getElementById('gambar_rangkuman');
            const label = document.getElementById('gambar_rangkuman-label');
            const filenameSpan = document.getElementById('gambar_rangkuman-filename');

            if (input.files && input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.classList.remove('text-gray-500');
                label.classList.add('text-black');
            } else {
                filenameSpan.textContent = '';
                label.textContent = 'File Gambar Belum Ditemukan';
                label.classList.remove('text-black');
                label.classList.add('text-gray-500');
            }

            checkRequiredFields();
        };

        const form = document.getElementById('rangkumanForm');
        const requiredFields = form.querySelectorAll('[required]');

        function checkRequiredFields() {
            let allFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim() || (field.type === 'radio' && !form.querySelector(
                        'input[name="tipe_rangkuman"]:checked'))) {
                    allFilled = false;
                }
            });

            document.getElementById('simpanBtn').disabled = !allFilled;
        }

        // Add input/file listeners
        requiredFields.forEach(field => {
            if (field.type === 'file') {
                field.addEventListener('change', checkRequiredFields);
            } else {
                field.addEventListener('input', checkRequiredFields);
            }
        });

        // Radio buttons for tipe_rangkuman
        const tipeRangkumanRadios = form.querySelectorAll('input[name="tipe_rangkuman"]');
        tipeRangkumanRadios.forEach(radio => {
            radio.addEventListener('change', checkRequiredFields);
        });

        // Trix-specific
        document.addEventListener("trix-change", function() {
            checkRequiredFields();
        });

        // Initial check
        checkRequiredFields();

        function showAlertSave() {
            Swal.fire({
                title: "Simpan Data Baru?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Data Baru Tersimpan", "", "success");
                    setTimeout(() => {
                        document.getElementById('rangkumanForm').submit();
                    }, 1000); // Wait for 1 seconds
                } else if (result.isDenied) {
                    Swal.fire("Data Tidak Disimpan", "", "error");
                }
            });
        }
    </script>

</x-layout_sistem_informasi>
