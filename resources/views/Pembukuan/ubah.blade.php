<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form action="{{ route('Pembukuan.update', $pembukuan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID PEMBUKUAN</label>
                        <input type="text" value="{{ $pembukuan->id_pembukuan }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NOMINAL</label>
                        <input type="text" name="nominal_pembukuan" id="nominal_pembukuan"
                            value="{{ number_format($pembukuan->nominal_pembukuan, 0, ',', ',') }}" autocomplete="off"
                            inputmode="numeric" pattern="[0-9,]*" class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TANGGAL</label>
                        <input type="text"
                            value="{{ \Carbon\Carbon::parse($pembukuan->tgl_pembukuan)->locale('id_ID')->isoFormat('DD MMMM Y') }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">TIPE</label>
                        {{-- <input type="text" value="{{ $pembukuan->jenis_pembukuan }}" class="w-full p-2 rounded bg-white"> --}}

                        <select name="jenis_pembukuan" class="w-full p-2 rounded bg-white">
                            <option value="Uang Masuk"
                                {{ $pembukuan->jenis_pembukuan == 'Uang Masuk' ? 'selected' : '' }}>
                                Uang Masuk</option>
                            <option value="Uang Keluar"
                                {{ $pembukuan->jenis_pembukuan == 'Uang Keluar' ? 'selected' : '' }}>Uang Keluar
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">DESKRIPSI</label>
                    <textarea class="w-full p-2 rounded bg-white resize-y min-h-[80px] max-h-[50vh]" name="deskripsi_pembukuan"
                        style="height: 120px;">{{ $pembukuan->deskripsi_pembukuan }}</textarea>
                </div>
            </div>

            <!-- Button -->
            <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
                <a href="/pembukuan">
                    <button class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                        BATAL
                    </button>
                </a>
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]" onclick="showAlert()">
                    SIMPAN
                </button>
            </div>
        </form>
    </div>
    </div>

    {{-- untuk ngehilangin koma pas udah submit --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('nominal_pembukuan');
                const error = document.getElementById('nominal-error');

                input.addEventListener('input', function(e) {
                    // Remove all non-digit characters
                    let value = input.value.replace(/[^0-9]/g, '');
                    // Format with thousand separators
                    if (value.length > 0) {
                        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        error.classList.add('hidden');
                    } else {
                        input.value = '';
                    }
                });

                // Optional: Prevent non-numeric keypresses
                input.addEventListener('keypress', function(e) {
                    if (!/[0-9]/.test(e.key)) {
                        e.preventDefault();
                        error.classList.remove('hidden');
                    } else {
                        error.classList.add('hidden');
                    }
                });

                // Remove commas before form submission
                input.form && input.form.addEventListener('submit', function() {
                    input.value = input.value.replace(/,/g, '');
                });
            });

            function showAlert() {
                Swal.fire({
                    title: "Do you want to save the changes?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    denyButtonText: `Don't save`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Swal.fire("Saved!", "", "success");
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
            }
        </script>
    @endpush
</x-layout_sistem_informasi>
