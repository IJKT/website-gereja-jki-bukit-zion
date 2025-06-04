<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    @if (Auth::check())
        <p class="font-bold">halo cok{{ Auth::user() }}</p>
    @endif
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                <div>
                    <label class="block font-semibold mb-1">NAMA</label>
                    <input type="text" value="{{ $user->jemaat->nama_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">ALAMAT EMAIL</label>
                    <input type="text" value="{{ $user->jemaat->email_jemaat }}" class="w-full p-2 rounded bg-white"
                        required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">NIK</label>
                    <input type="text" value="{{ $user->jemaat->nik_jemaat }}" class="w-full p-2 rounded bg-gray-100"
                        disabled>
                </div>

                <div>
                    <label class="block font-semibold mb-1">TEMPAT & TGL LAHIR</label>
                    <div class="flex justify-between gap-2">
                        <input type="text" value="{{ $user->jemaat->tmpt_lahir_jemaat }}"
                            class="w-full p-2 rounded bg-gray-100" disabled>
                        <input type="date" name="tgl_ibadah"
                            value="{{ \Carbon\Carbon::parse($user->jemaat->tgl_lahir_jemaat)->format('Y-m-d') }}"
                            class="w-full p-2 rounded bg-gray-100" max="{{ now()->format('Y-m-d') }}" disabled>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">ALAMAT</label>
                    <input type="text" value="{{ $user->jemaat->alamat_jemaat }}" class="w-full p-2 rounded bg-white"
                        required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">JENIS KELAMIN</label>
                    <input type="text"
                        value=
                        "@if ($user->jemaat->jk_jemaat == 'P') Pria
                        @else Wanita @endif"
                        class="w-full p-2 rounded bg-gray-100" disabled>
                </div>

                <div>
                    <label class="block font-semibold mb-1">NOMOR HP</label>
                    <input type="text" value="{{ $user->jemaat->telp_jemaat }}" class="w-full p-2 rounded bg-white"
                        required>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <button class="bg-red-500  px-6 py-2 rounded-md hover:bg-red-600">LOGOUT
            </button>
            <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">UBAH
            </button>
        </div>
    </div>
</x-layout_sistem_informasi>
