<div class="w-1/5 bg-[#424242] text-white p-4 h-screen" x-data="{ openSub1: false, openSub2: false }">
    <ul class="space-y-2 relative">
        <a href="/profil">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] 
            {{ request()->is('profil') ? 'bg-[#215773]' : '' }}">
                Profil</li>
        </a>

        {{-- pengajuan --}}
        <li class="font-bold text-md rounded-md px-2 py-1 -mb-0.5 relative hover:bg-[#5d5d5d]
        {{ request()->is('pengajuan/*') ? 'bg-[#215773]' : '' }}"
            @mouseenter="openSub1 = true" @mouseleave="openSub1 = false">
            Pengajuan
            <span class="text right float-right">
                <svg class="h-4 w-4 mt-1" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                </svg>
            </span>
            <ul class="absolute top-0 left-full bg-[#424242] w-40 rounded-md shadow-lg" :aria-checked="openSub1"
                :class="{ 'block': openSub1, 'hidden': !openSub1 }">
                <a href="/pengajuan/baptis">
                    <li
                        class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('pengajuan/baptis') ? 'bg-[#215773]' : '' }}">
                        Baptis
                    </li>
                </a>
                <a href="/pengajuan/pernikahan">
                    <li
                        class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('pengajuan/pernikahan') ? 'bg-[#215773]' : '' }}">
                        Pernikahan
                    </li>
                </a>
            </ul>
        </li>

        {{-- manajemen --}}
        <li class="font-bold text-md rounded-md px-2 py-1 -mb-0.5 relative hover:bg-[#5d5d5d]
        {{ request()->is('manajemen/*') ? 'bg-[#215773]' : '' }}"
            @mouseenter="openSub2 = true" @mouseleave="openSub2 = false">
            Manajemen
            <span class="text right float-right">
                <svg class="h-4 w-4 mt-1" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                </svg>
            </span>
            <ul class="absolute top-0 left-full bg-[#424242] w-40 rounded-md shadow-lg" :aria-checked="openSub2"
                :class="{ 'block': openSub2, 'hidden': !openSub2 }">
                <a href="/manajemen/pelayan">
                    <li
                        class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('manajemen/pelayan', 'manajemen/pelayan/*') ? 'bg-[#215773]' : '' }}">
                        Pelayan
                    </li>
                </a>
                <a href="/manajemen/jemaat">
                    <li
                        class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('manajemen/jemaat', 'manajemen/jemaat/*') ? 'bg-[#215773]' : '' }}">
                        Jemaat
                    </li>
                </a>
                <a href="/manajemen/riwayat">
                    <li
                        class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('manajemen/riwayat') ? 'bg-[#215773]' : '' }}">
                        Riwayat
                    </li>
                </a>
            </ul>
        </li>

        <a href="/pembukuan">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d]
            {{ request()->is('pembukuan') ? 'bg-[#215773]' : '' }}">
                Pembukuan</li>
        </a>

        <a href="/jadwal">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d]
            {{ request()->is('jadwal') ? 'bg-[#215773]' : '' }}">
                Jadwal</li>
        </a>

        <a href="/sermons-articles">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d]
            {{ request()->is('sermons-articles') ? 'bg-[#215773]' : '' }}">
                Sermons & Articles</li>
        </a>

        <a href="/lagu">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d]
            {{ request()->is('lagu') ? 'bg-[#215773]' : '' }}">
                Lagu</li>
        </a>

    </ul>
</div>
