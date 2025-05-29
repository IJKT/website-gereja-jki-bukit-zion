<x-layout_sistem_informasi>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- main content --}}
    <div class="flex-1 bg-white p-10">
        <div class="bg-gray-200 p-6 rounded-md">
            <div x-data="jemaatSearch()" class="grid grid-cols-2 gap-x-10 gap-y-4">
                <div>
                    <label class="block font-semibold mb-1">ID PELAYAN</label>
                    <input type="text" value="{{ $id_pelayan }}" class="w-full p-2 rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block font-semibold mb-1">USERNAME</label>
                    <input type="text" class="w-full p-2 rounded bg-gray-100" x-model="username" disabled>
                </div>

                {{-- 
                TODO: benerin dropdown nama lengkapnya
                --}}
                <div>
                    <label class="block font-semibold mb-1">NAMA LENGKAP</label>
                    <input type="text" class="w-full p-2 rounded bg-white" x-model="query"
                        @input.debounce.300ms="search" @focus="showDropdown = true"
                        @blur="setTimeout(() => showDropdown = false, 200)" autocomplete="off">
                    <div class="absolute z-10 bg-white border w-full mt-1 rounded shadow max-h-60 overflow-y-auto"
                        x-show="showDropdown && results.length" x-transition>
                        <template x-for="result in results" :key="result.id">
                            <div class="px-4 py-2 hover:bg-gray-200 cursor-pointer" @mousedown.prevent="select(result)">
                                <span x-text="result.nama_jemaat"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div x-data="{ hak_akses: '' }">
                <label class="block font-semibold my-1">HAK AKSES</label>
                <div class="grid grid-cols-2 gap-x-10 gap-y-4 w-1/2">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Administrator'" :checked="hak_akses === 'Administrator'">
                        <span
                            :class="hak_akses == 'Administrator' ? 'font-semibold' : 'font-normal'">Administrator</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses"class="form-radio text-[#215773]"
                            @click="hak_akses = 'Multimedia'" :checked="hak_akses === 'Multimedia'">
                        <span :class="hak_akses == 'Multimedia' ? 'font-semibold' : 'font-normal'">Multimedia</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Koordinator'" :checked="hak_akses === 'Koordinator'">
                        <span :class="hak_akses == 'Koordinator' ? 'font-semibold' : 'font-normal'">Koordinator</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Praise & Worship'" :checked="hak_akses === 'Praise & Worship'">
                        <span :class="hak_akses == 'Praise & Worship' ? 'font-semibold' : 'font-normal'">Praise &
                            Worship</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Bendahara'" :checked="hak_akses === 'Bendahara'">
                        <span :class="hak_akses == 'Bendahara' ? 'font-semibold' : 'font-normal'">Bendahara</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="hak-akses" class="form-radio text-[#215773]"
                            @click="hak_akses = 'Pelayan Gereja'" :checked="hak_akses === 'Pelayan Gereja'">
                        <span :class="hak_akses == 'Pelayan Gereja' ? 'font-semibold' : 'font-normal'">Pelayan
                            Gereja</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="fixed bottom-0 right-0 mb-4 mr-4 text-white font-bold">
            <a href="/manajemen/pelayan">
                <button class="text-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60] hover:text-white">
                    BATAL
                </button>
            </a>
            <a href="#">
                <button class="bg-[#215773]  px-6 py-2 rounded-md hover:bg-[#1a4a60]">
                    SIMPAN
                </button>
            </a>
        </div>
    </div>
    </div>

    {{-- <script>
        function jemaatSearch() {
            return {
                query: '',
                results: [],
                showDropdown: false,
                username: '',
                search() {
                    if (this.query.length < 2) {
                        this.results = [];
                        return;
                    }
                    fetch(`/api/jemaat-search?query=${encodeURIComponent(this.query)}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data;
                        });
                },
                select(result) {
                    this.query = result.nama_jemaat;
                    this.username = result.username || result.nama_jemaat.toLowerCase().replace(/\s+/g,
                        '.'); // Fallback if username not provided
                    this.showDropdown = false;
                }
            }
        }
    </script> --}}
</x-layout_sistem_informasi>
