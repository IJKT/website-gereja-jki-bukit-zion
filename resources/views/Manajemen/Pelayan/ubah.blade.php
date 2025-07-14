<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <form id="pelayanForm" action="{{ route('Manajemen.Pelayan.update', $pelayan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-200 p-6 rounded-md">
                <h2 class="font-bold mb-4">UBAH DATA PELAYAN</h2>
                <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                    <div>
                        <label class="block font-semibold mb-1">ID PELAYAN</label>
                        <input type="text" value="{{ $pelayan['id_pelayan'] }}" class="w-full p-2 rounded bg-gray-100"
                            disabled>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">USERNAME</label>
                        <input type="text" value="{{ $pelayan->jemaat->username }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                        <input type="text" value="{{ $pelayan->jemaat->nama_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                    </div>
                </div>

                <div x-data="{ hak_akses: '{{ $pelayan['hak_akses_pelayan'] }}' }">
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
        </form>
        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <form id="statusForm" action="{{ route('Manajemen.Pelayan.status', $pelayan) }}" method="POST"
                style="display:none;">
                @csrf
                @method('PUT')
                <input type="hidden" name="status_pelayan" value="{{ $pelayan->status_pelayan == 1 ? 0 : 1 }}">
            </form>

            @php
                $currentRole = Auth::user()->jemaat->pelayan->hak_akses_pelayan;
                $targetRole = $pelayan->hak_akses_pelayan;

                $canEdit = false;

                if ($currentRole == 'Super Admin') {
                    $canEdit = true;
                } elseif ($currentRole == 'Administrator' && $targetRole != 'Super Admin') {
                    $canEdit = true;
                } elseif (
                    $currentRole == 'Koordinator' &&
                    $targetRole != 'Super Admin' &&
                    $targetRole != 'Administrator'
                ) {
                    $canEdit = true;
                }
            @endphp

            @if ($canEdit)
                @if ($pelayan->status_pelayan == 1)
                    <button type="button" class="bg-red-500  px-6 py-2 rounded-md hover:bg-red-700"
                        onclick="showAlertNonactivate()">
                        NONAKTIF
                    </button>
                @elseif ($pelayan->status_pelayan == 0)
                    <button type="button" class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]"
                        onclick="showAlertActivate()">
                        AKTIF
                    </button>
                @endif
                <button
                    class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] disabled:bg-gray-400 disabled:text-gray-200"
                    onclick="showAlertSave()">
                    SIMPAN
                </button>
            @endif
            <a href="{{ route('Manajemen.Pelayan.viewall') }}">
                <button class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
        </div>
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
                    // Remove commas before submit
                    Swal.fire("Perubahan Diubah", "", "success");
                    // Submit the form
                    document.getElementById('pelayanForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Perubahan Tidak Diubah", "", "error");
                }
            });
        }

        function showAlertNonactivate() {
            Swal.fire({
                title: "Nonaktifkan Pelayan?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Pelayan Dinonaktifkan", "", "success");
                    // Submit the status form
                    document.getElementById('statusForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Pelayan Tidak Diubah", "", "error");
                }
            });
        }

        function showAlertActivate() {
            Swal.fire({
                title: "Aktifkan Pelayan?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: "Simpan",
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Pelayan Diaktifkan", "", "success");
                    // Submit the status form
                    document.getElementById('statusForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Pelayan Tidak Diubah", "", "error");
                }
            });
        }
    </script>
</x-layout_sistem_informasi>
