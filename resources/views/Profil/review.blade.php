<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <form id="jemaatForm" action="{{ route('Profil.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                    <div>
                        <label class="block font-semibold mb-1">NAMA</label>
                        <input type="text" name="nama" value="{{ $user->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ALAMAT EMAIL</label>
                        <input type="text" name="email" value="{{ $user->jemaat->email_jemaat }}"
                            autocomplete="off" class="w-full p-2 rounded bg-white" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">NIK</label>
                        <input type="text" name="nik" value="{{ $user->jemaat->nik_jemaat }}" autocomplete="off"
                            pattern="[0-9]+" minlength="16"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">WILAYAH KOMSEL</label>
                        <input type="text" name="komsel" value="{{ $user->jemaat->wilayah_komsel_jemaat }}"
                            placeholder="Tambahkan wilayah komsel" autocomplete="off"
                            class="w-full p-2 rounded bg-white" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">TEMPAT & TGL LAHIR</label>
                        <div class="flex justify-between gap-2">
                            <input type="text" name="tempat_lahir" value="{{ $user->jemaat->tmpt_lahir_jemaat }}"
                                class="w-full p-2 rounded bg-white" required>
                            <input type="date" name="tanggal_lahir"
                                value="{{ \Carbon\Carbon::parse($user->jemaat->tgl_lahir_jemaat)->format('Y-m-d') }}"
                                class="w-full p-2 rounded bg-white" max="{{ now()->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">ALAMAT</label>
                        <input type="text" name="alamat" value="{{ $user->jemaat->alamat_jemaat }}"
                            autocomplete="off" class="w-full p-2 rounded bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">JENIS KELAMIN</label>
                        <input type="hidden" name="jk" value="{{ $user->jemaat->jk_jemaat }}">
                        <select class="w-full p-2 rounded bg-white">
                            <option value="P" {{ $user->jemaat->jk_jemaat == 'P' ? 'selected' : '' }}>Pria
                            </option>
                            <option value="W" {{ $user->jemaat->jk_jemaat == 'W' ? 'selected' : '' }}>Wanita
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">NOMOR HP</label>
                        <input type="tel" name="nomor_hp" value="{{ $user->jemaat->telp_jemaat }}"
                            class="w-full p-2 rounded bg-white" autocomplete="off" pattern="[0-9]+" minlength="8"
                            required onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                    </div>

                    {{-- Field komentar jika belum terverifikasi --}}
                    <div class="col-span-2">
                        <label class="block font-semibold mb-1">KOMENTAR</label>
                        <textarea class="w-full p-3 rounded bg-gray-100 border resize-y border-gray-300 min-h-[10vh] max-h-[25vh]"
                            placeholder="Tidak Ada Komentar" disabled>{{ $user->catatan_verif_user }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="{{ route('logout') }}">
                <button class="bg-red-500 px-6 py-2 rounded-md hover:bg-red-600">LOGOUT</button>
            </a>
            <button class="bg-[#215773] px-6 py-2 rounded-md hover:bg-[#1a4a60]" id="simpanBtn"
                onclick="showAlertSave()">UBAH</button>
        </div>
    </div>

    <script>
        function showAlertSave() {
            Swal.fire({
                title: "Simpan perubahan?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Perubahan disimpan!", "", "success");
                    document.getElementById('jemaatForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Perubahan dibatalkan", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
