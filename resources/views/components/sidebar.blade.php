<!-- TODO: buat logout button-->
<!-- TODO: buat dashboard button-->
<!-- TODO: buat biar lebih dinamis dengan tampilan hp-->

<div class="w-1/5 bg-[#424242] text-white p-4 h-screen" x-data="{ openSub1: false, openSub2: false }">
    <ul class="space-y-2 relative">
        <a href="{{ route('Dashboard.index') }}">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] 
            {{ request()->is('dashboard') ? 'bg-[#215773]' : '' }}">
                Dashboard</li>
        </a>
        <a href="{{ route('Profil.profil') }}">
            <li
                class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] 
            {{ request()->is('profil') ? 'bg-[#215773]' : '' }}">
                Profil</li>
        </a>
        {{-- pengajuan --}}
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
                <ul class="absolute top-0 left-full bg-[#424242] w-40 rounded-md shadow-lg" :aria-checked="openSub1"
                    :class="{ 'block': openSub1, 'hidden': !openSub1 }">
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
            {{-- manajemen --}}
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
                    <ul class="absolute top-0 left-full bg-[#424242] w-40 rounded-md shadow-lg" :aria-checked="openSub2"
                        :class="{ 'block': openSub2, 'hidden': !openSub2 }">
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

            {{-- pembukuan --}}
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Administrator' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Bendahara' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                <a href="{{ route('Pembukuan.viewall') }}">
                    <li
                        class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is('pembukuan', 'pembukuan/*') ? 'bg-[#215773]' : '' }}">
                        Pembukuan</li>
                </a>
            @endif

            {{-- lagu --}}
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Praise & Worship' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                <a href="{{ route('LaguPujian.viewall') }}">
                    <li
                        class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['lagu', 'lagu/*']) ? 'bg-[#215773]' : '' }}">
                        Lagu</li>
                </a>
            @endif

            {{-- jadwal --}}
            <a href="{{ route('Jadwal.viewall') }}">
                <li
                    class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['jadwal', 'jadwal/*']) ? 'bg-[#215773]' : '' }}
">
                    Jadwal</li>
            </a>

            {{-- rangkuman firman --}}
            @if (Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Multimedia' ||
                    Auth::user()->jemaat->pelayan->hak_akses_pelayan == 'Super Admin')
                <a href="{{ route('RangkumanFirman.viewall') }}">
                    <li
                        class="font-bold rounded-md text-md px-2 py-1 hover:bg-[#5d5d5d] {{ request()->is(['sermons-articles', 'sermons-articles/*']) ? 'bg-[#215773]' : '' }}">
                        Sermons & Articles</li>
                </a>
            @endif
        @endif
    </ul>
</div>
