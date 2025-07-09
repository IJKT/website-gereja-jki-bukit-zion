<div class="fixed inset-y-0 left-0 z-40 w-64 transform bg-[#424242] text-white shadow-lg transition-transform duration-300 ease-in-out"
    x-data="{ openSub1: false, openSub2: false, openSub3: false }" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="p-4 overflow-y-auto overflow-x-hidden h-full">
        <ul class="space-y-2 relative">
            <a href="{{ route('Dashboard.index') }}">
                <li
                    class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] 
            {{ request()->is('dashboard') ? 'bg-[#215773]' : '' }}">
                    Dashboard</li>
            </a>
            @if (Auth::user()->verifikasi_user == 1)
                <li class="font-bold text-md rounded-md px-2 py-1 relative {{ request()->is('pengajuan/*') ? 'bg-[#215773]' : '' }}"
                    @click="openSub1 = !openSub1" :class="{ 'bg-[#424242]': openSub1 }" style="cursor: pointer;">
                    Pengajuan
                    <span class="float-right">
                        <svg class="h-4 w-4 mt-1 transform" :class="{ 'rotate-90': openSub1 }" viewBox="0 0 15 15"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                        </svg>
                    </span>

                    <ul x-show="openSub1" x-transition
                        class="bg-[#333] rounded-md ml-4 overflow-hidden max-h-0 duration-300 ease-in-out"
                        :class="{ 'max-h-96': openSub1 }">
                        <a href="{{ route('PengajuanJemaat.baptis') }}">
                            <li
                                class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is('pengajuan/baptis') ? 'bg-[#215773]' : '' }}">
                                Baptis
                            </li>
                        </a>
                        <a href="{{ route('PengajuanJemaat.pernikahan') }}">
                            <li
                                class="font-bold text-md rounded-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is('pengajuan/pernikahan') ? 'bg-[#215773]' : '' }}">
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
                    <li class="font-bold text-md rounded-md px-2 py-1 relative {{ request()->is('manajemen/*') ? 'bg-[#215773]' : '' }}"
                        @click="openSub2 = !openSub2" :class="{ 'bg-[#424242]': openSub2 }" style="cursor: pointer;">
                        Manajemen
                        <span class="text right float-right">
                            <svg class="h-4 w-4 mt-1 transform" :class="{ 'rotate-90': openSub2 }" viewBox="0 0 15 15"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                            </svg>
                        </span>
                        <ul x-show="openSub2" x-transition
                            class="bg-[#333] rounded-md ml-4 overflow-hidden max-h-0 duration-300 ease-in-out"
                            :class="{ 'max-h-96': openSub2 }">
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
                        class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['jadwal', 'jadwal/*']) ? 'bg-[#215773]' : '' }}">
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

                <!-- Contact -->
                @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Koordinator' ||
                        Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                    <a href="{{ route('Kontak.index') }}">
                        <li
                            class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['kontak', 'kontak/*']) ? 'bg-[#215773]' : '' }}">
                            Kontak</li>
                    </a>
                @endif
            @endif


            <!-- Pengaturan -->
            <li class="font-bold text-md rounded-md px-2 py-1 relative
        {{ request()->is('profil') ? 'bg-[#215773]' : '' }}"
                @click="openSub3 = !openSub3" :class="{ 'bg-[#424242]': openSub3 }" style="cursor: pointer;">
                Pengaturan

                <span class="text right float-right">
                    <svg class="h-4 w-4 mt-1 transform" :class="{ 'rotate-90': openSub3 }" viewBox="0 0 15 15"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 7.5L4 0V15L12 7.5Z" fill="#ffffff" />
                    </svg>
                </span>
                <ul x-show="openSub3" x-transition
                    class="bg-[#333] rounded-md ml-4 overflow-hidden max-h-0 duration-300 ease-in-out"
                    :class="{ 'max-h-96': openSub3 }">
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
        </ul>
    </div>
</div>
