<x-layout_home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="max-w-3xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-center mb-4">Contact</h1>
        <p class="text-center text-gray-600 mb-8">
            Silakan hubungi kami melalui informasi di bawah ini atau kirim pesan langsung menggunakan formulir.
        </p>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">Informasi Kontak</h2>
            <ul class="space-y-2 text-gray-700">
                <li><strong>Alamat:</strong> Jl. Manyar Kartika Timur 2-6</li>
                <li><strong>Telepon:</strong> 031-5911957</li>
                <li><strong>Email:</strong> info@bukitzion.com</li>
            </ul>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Kirim Pesan</h2>
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: '{{ session('success') }}'
                        });
                    });
                </script>
            @endif
            <form method="POST" id="KontakForm" action="{{ route('Home.contact_send') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block mb-1 font-medium">Nama</label>
                    <input type="text" name="name"
                        class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        border-gray-300 rounded-md p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        placeholder="Masukkan Nama Anda" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" name="email"
                        class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        placeholder="Masukkan Email Anda" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Kategori</label>
                    <select name="category" id="category"
                        class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Umum">Umum</option>
                        <option value="Pembaptisan">Pembaptisan</option>
                        <option value="Pernikahan">Pernikahan</option>
                        <option value="Persembahan">Persembahan</option>
                    </select>
                </div>
        </div>
        <div>
            <label class="block mb-1 font-medium">Pesan</label>
            <textarea name="message" rows="5"
                class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                placeholder="Masukkan Pesan" required></textarea>
        </div>
        <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] text-white font-bold"
            id="simpanBtn">
            SUBMIT
        </button>

        </form>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('simpanBtn');
            const form = btn.closest('form');

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin mengirim pesan ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#215773',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kirim',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('KontakForm').submit();
                    }
                });
            });
        });
    </script>

</x-layout_home>
