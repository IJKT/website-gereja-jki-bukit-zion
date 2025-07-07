<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="KontakForm" action="{{ route('Kontak.Send', $kontak) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">BALAS PESAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-2">
                    <div>
                        <label class="block font-semibold mb-1">ID KONTAK</label>
                        <input type="text" value="{{ $kontak->id_kontak }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">NAMA</label>
                        <input type="text" value="{{ $kontak->nama }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">EMAIL</label>
                        <input type="text" name="email_jemaat" value="{{ $kontak->email }}"
                            class="w-full p-2 rounded bg-gray-100" disabled autocomplete="off">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">KATEGORI</label>
                        <input type="text" name="email_jemaat" value="{{ $kontak->kategori }}"
                            class="w-full p-2 rounded bg-gray-100" disabled autocomplete="off">
                    </div>

                </div>

                <div>
                    <label class="block font-semibold my-1">PESAN</label>
                    <textarea class="w-full p-2 rounded bg-gray-100" rows="4" disabled>{{ $kontak->pesan }}</textarea>
                </div>
                <div>
                    <label class="block font-semibold my-1">BALASAN</label>
                    <textarea class="w-full p-2 rounded bg-white" name="balasan" rows="4" required></textarea>
                </div>
            </div>
        </form>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button
                class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200"
                id="simpanBtn" onclick="showAlertSave()" disabled>
                BALAS
            </button>
            <a href="{{ route('Manajemen.Jemaat.viewall') }}">
                <button type="button" class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
        </div>
    </div>

    <script>
        // Function to check if all required fields are filled
        function checkRequiredFields() {
            const form = document.getElementById('KontakForm');
            const requiredFields = form.querySelectorAll('[required]');
            let allFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFilled = false;
                }
            });
            document.getElementById('simpanBtn').disabled = !allFilled;
        }
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('KontakForm');
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
            });
            checkRequiredFields();
        });

        function showAlertSave() {
            Swal.fire({
                title: "Balas Pesan?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Pesan Telah Dibalas", "", "success");
                    setTimeout(() => {
                        document.getElementById('KontakForm').submit();
                    }, 1000); // Wait for 1 seconds
                } else if (result.isDenied) {
                    Swal.fire("Pisan Tidak Dikirimkan", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
