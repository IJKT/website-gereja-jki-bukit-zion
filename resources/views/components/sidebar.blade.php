<div class="w-1/5 bg-[#424242] text-white p-4 min-h-screen max-h-[300vh]" x-data="{ openSub1: false, openSub2: false, openSub3: false }">
    <ul class="space-y-2 relative">
        <a href="{{ route('Dashboard.index') }}">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] 
            {{ request()->is('dashboard') ? 'bg-[#215773]' : '' }}">
                Dashboard</li>
        </a>
        @if (Auth::user()->verifikasi_user == 1)
            <li class="font-bold text-md rounded-md px-2 py-1 -mb-0.5 relative hover:bg-[#5d5d5d]
        {{ request()->is('pengajuan/*') ? 'bg-[#215773]' : '' }}"
                @mouseenter="openSub1 = true" @mouseleave="openSub1 = false">
                Pengajuan

                <span class="text right float-right">
                    <svg class="h-4 w-4 mt-1" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                    </svg>
                </span>
                <ul x-cloak class="absolute top-0 left-full bg-[#424242] w-40 rounded-md shadow-lg"
                    :aria-checked="openSub1" :class="{ 'block': openSub1, 'hidden': !openSub1 }">
                    <a href="{{ route('PengajuanJemaat.baptis') }}">
                        <li
                            class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('pengajuan/baptis') ? 'bg-[#215773]' : '' }}">
                            Baptis
                        </li>
                    </a>
                    <a href="{{ route('PengajuanJemaat.pernikahan') }}">
                        <li
                            class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('pengajuan/pernikahan') ? 'bg-[#215773]' : '' }}">
                            Pernikahan
                        </li>
                    </a>
                </ul>
            </li>
        @endif
        @if (Auth::user()->jemaat->hak_akses_jemaat == 'Pelayan')
            <!-- manajemen -->
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Koordinator' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                <li class="font-bold text-md rounded-md px-2 py-1 -mb-0.5 relative hover:bg-[#5d5d5d] {{ request()->is('manajemen/*') ? 'bg-[#215773]' : '' }}"
                    @mouseenter="openSub2 = true" @mouseleave="openSub2 = false"> Manajemen
                    <span class="text right float-right">
                        <svg class="h-4 w-4 mt-1" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                        </svg>
                    </span>
                    <ul x-cloak class="absolute top-0 left-full bg-[#424242] w-40 rounded-md shadow-lg"
                        :aria-checked="openSub2" :class="{ 'block': openSub2, 'hidden': !openSub2 }">
                        <a href="{{ route('Manajemen.Pelayan.viewall') }}">
                            <li
                                class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('manajemen/pelayan', 'manajemen/pelayan/*') ? 'bg-[#215773]' : '' }}">
                                Pelayan
                            </li>
                        </a>
                        <a href="{{ route('Manajemen.Jemaat.viewall') }}">
                            <li
                                class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('manajemen/jemaat', 'manajemen/jemaat/*', 'manajemen/pengajuan', 'manajemen/pengajuan/*') ? 'bg-[#215773]' : '' }}">
                                Jemaat
                            </li>
                        </a>
                        <a href="{{ route('Manajemen.Riwayat') }}">
                            <li
                                class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]
                    {{ request()->is('manajemen/riwayat') ? 'bg-[#215773]' : '' }}">
                                Riwayat
                            </li>
                        </a>
                    </ul>
                </li>
            @endif

            <!-- pembukuan -->
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Bendahara' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                <a href="{{ route('Pembukuan.viewall') }}">
                    <li
                        class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is('pembukuan', 'pembukuan/*') ? 'bg-[#215773]' : '' }}">
                        Pembukuan</li>
                </a>
            @endif

            <!-- lagu -->
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Praise & Worship' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                <a href="{{ route('LaguPujian.viewall') }}">
                    <li
                        class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['lagu', 'lagu/*']) ? 'bg-[#215773]' : '' }}">
                        Lagu</li>
                </a>
            @endif

            <!-- jadwal -->
            <a href="{{ route('Jadwal.viewall') }}">
                <li
                    class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['jadwal', 'jadwal/*']) ? 'bg-[#215773]' : '' }}
">
                    Jadwal</li>
            </a>

            <!-- rangkuman firman -->
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Multimedia' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                <a href="{{ route('RangkumanFirman.viewall') }}">
                    <li
                        class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['sermons-articles', 'sermons-articles/*']) ? 'bg-[#215773]' : '' }}">
                        Sermons & Articles</li>
                </a>
            @endif
            <!-- Pengaturan -->
            <li class="font-bold text-md rounded-md px-2 py-1 -mb-0.5 relative hover:bg-[#5d5d5d]
        {{ request()->is('profil') ? 'bg-[#215773]' : '' }}"
                @mouseenter="openSub3 = true" @mouseleave="openSub3 = false">
                Pengaturan

                <span class="text right float-right">
                    <svg class="h-4 w-4 mt-1" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                    </svg>
                </span>
                <ul x-cloak class="absolute top-0 left-full bg-[#424242] w-40 rounded-md shadow-lg"
                    :aria-checked="openSub3" :class="{ 'block': openSub3, 'hidden': !openSub3 }">
                    <a href="{{ route('Profil.profil') }}">
                        <li class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]">
                            Profil
                        </li>
                    </a>
                    <a href="{{ route('logout') }}">
                        <li class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d]">
                            Logout
                        </li>
                    </a>
                </ul>
            </li>
        @endif
    </ul>
</div>



<!-- Sidebar GPT -->
{{-- <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

    <!-- Top Bar (Mobile Only) -->
    <header class="w-full flex items-center justify-between bg-white shadow px-4 py-3 sm:hidden">
        <h1 class="text-lg font-semibold">Mt. Zion Church</h1>
        <button @click="sidebarOpen = true" class="text-gray-600 focus:outline-none">
            <!-- Burger Icon -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen || window.innerWidth >= 640"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform transition-transform sm:static sm:translate-x-0"
        :class="{ '-translate-x-full': !sidebarOpen && window.innerWidth < 640 }" @click.away="sidebarOpen = false">
        <div class="h-full overflow-y-auto p-4 bg-gray-50">
            <ul class="space-y-2" x-data="{ open: false }">
                <li>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Dashboard</a>
                </li>
                <li>
                    <button @click="open = !open"
                        class="w-full text-left px-4 py-2 rounded hover:bg-gray-200 flex justify-between items-center">
                        Menu Multi-Level
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <ul x-show="open" class="ml-4 mt-2 space-y-1">
                        <li><a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Submenu 1</a></li>
                        <li><a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Submenu 2</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Pengaturan</a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen && window.innerWidth < 640" class="fixed inset-0 z-30 bg-black bg-opacity-50 sm:hidden"
        @click="sidebarOpen = false"></div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Top Bar (visible only on mobile) -->
        <header class="flex items-center justify-between bg-white shadow p-4 sm:hidden">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none">
                ☰
            </button>
            <h1 class="text-lg font-semibold">Dashboard</h1>
        </header>

        <!-- Content -->
        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div> --}}
