<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        {{-- <form id="jadwalForm" action="{{ route('Jadwal.update', $jadwal) }}" method="POST">
            @csrf
            @method('PUT') --}}
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
                {{-- <div>
                    <label class="block font-semibold mb-1">BACKTRACK</label>
                    <input type="file" name="tgl_ibadah" value="{{ $jadwal->backtrack }}"
                        class="w-full p-2 rounded bg-white" placeholder="File Backtrack Belum Ditemukan">
                </div> --}}
                <div>
                    {{-- to remove te file name --}}
                    @php
                        $backtrackFileName = $jadwal->backtrack
                            ? \Illuminate\Support\Str::after($jadwal->backtrack, 'backtracks/')
                            : null;
                    @endphp

                    <label class="block font-semibold mb-1">BACKTRACK</label>
                    {{-- <div class="relative">
                        <input type="file" value="{{ $jadwal->backtrack }}" name="backtrack" id="backtrack"
                            accept=".mp3" class="hidden" onchange="updateBacktrackLabel()" required>
                        <label for="backtrack" id="backtrack-label"
                            class="w-full p-2 rounded bg-white cursor-pointer block text-gray-500 ">
                            File Backtrack Belum Ditemukan
                        </label>
                    </div>
                    <span id="backtrack-filename" class="block text-sm text-gray-700 mt-1"></span> --}}
                    @if ($jadwal->backtrack)
                        <input type="file" name="backtrack" id="backtrack" accept=".mp3" class="hidden"
                            onchange="updateBacktrackLabel()" required>
                        <label for="backtrack" id="backtrack-label"
                            class="w-full p-2 rounded bg-white cursor-pointer block ">
                            {{ $backtrackFileName }}
                        </label>
                        <div class="flex items-center space-x-2 mt-2">
                            <a href="{{ asset('storage/' . $jadwal->backtrack) }}" download
                                class="px-3 py-1 bg-[#215773] text-white rounded hover:bg-[#1a4a60]">
                                Download
                            </a>
                        </div>
                    @else
                        <input type="file" name="backtrack" id="backtrack" accept=".mp3" class="hidden"
                            onchange="updateBacktrackLabel()" required>
                        <label for="backtrack" id="backtrack-label"
                            class="w-full p-2 rounded bg-white cursor-pointer block text-gray-500 ">
                            File Backtrack Belum Ditemukan
                        </label>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- </form> --}}

    <!-- Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
        <a href="/jadwal">
            <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                BATAL
            </button>
        </a>
        <button type="button"
            class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
            PENDETA/MUSIK
        </button>
        <button type="button"
            class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
            MULTIMEDIA
        </button>
        <button type="button" id="simpanBtn" onclick="showAlertSave()" disabled
            class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
            SIMPAN
        </button>
    </div>
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

        // Attach event listeners to required fields
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('pembukuanForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
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
                    // document.getElementById('pembukuanForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Perubahan tidak diubah", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
