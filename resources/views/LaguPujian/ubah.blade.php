<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <form id="laguForm" action="{{ route('LaguPujian.update', $lagu) }}" method="POST">
                @csrf
                @method('PUT')
                <h2 class="font-bold mb-4">UBAH DAFTAR LAGU</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID DAFTAR LAGU</label>
                        <input type="text" name="id_lagu" value="{{ $lagu->id_lagu }}"
                            class="w-full p-2 rounded bg-gray-100" readonly>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NAMA LAGU</label>
                        <input type="text" name="nama_lagu" value="{{ $lagu->nama_lagu }}" autocomplete="off"
                            placeholder="Masukkan Judul Lagu" class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">LINK LAGU</label>
                        <input type="text" name="link_lagu" value="{{ $lagu->link_lagu }}" autocomplete="off"
                            class="w-full p-2 rounded bg-white" placeholder="Masukkan link lagu" required>
                    </div>
                    <!-- Button -->
                    <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
                        <a href="/lagu">
                            <button type="button"
                                class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                                BATAL
                            </button>
                        </a>
                        <button type="button" id="simpanBtn" onclick="showAlertSave()" disabled
                            class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200">
                            SIMPAN
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- untuk ngehilangin koma pas udah submit --}}
    @stack('scripts')
    <script>
        // Function to check if all required fields are filled
        function checkRequiredFields() {
            const form = document.getElementById('laguForm');
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
            const form = document.getElementById('laguForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
            });
            checkRequiredFields(); // Initial check
        });

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
                    document.getElementById('laguForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Perubahan tidak diubah", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
