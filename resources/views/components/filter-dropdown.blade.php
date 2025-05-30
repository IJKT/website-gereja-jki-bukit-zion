<div x-data="{ open: false }" class="relative inline-block text-left">
    <!-- Filter Button -->
    <button @click="open = !open" type="button"
        class="bg-[#215773] text-white px-2 py-2 rounded hover:bg-[#1a4a60] flex items-center gap-2"
        aria-label="Open filter" :aria-expanded="open">
        <svg class="h-5 w-5 font-bold" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 2.5H15M3 7.5H12M5 12.5H10" stroke="#ffffff" />
        </svg>
        <span class="sr-only">Filter</span>
    </button>

    <!-- Filter Dropdown -->
    <div x-show="open" @click.away="open = false" x-transition
        class="origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-gray-200 ring-1 ring-white ring-opacity-5 z-50"
        style="display: none;">
        {{ $slot }}
        <div class="flex justify-end gap-2 mb-2">
            <button type="submit"
                class="bg-[#215773] text-white font-semibold px-3 py-1 rounded hover:bg-[#1a4a60]">CARI</button>
            <button type="reset"
                class="bg-gray-200 text-gray-700 font-semibold px-3 py-1 rounded hover:bg-gray-300">ULANG</button>
            </form>
        </div>
    </div>
</div>
