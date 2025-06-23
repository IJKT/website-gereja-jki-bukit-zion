<header class="bg-[#31333B]" x-data="{ isOpen: false }">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
        {{-- logo kiri --}}
        <div class="flex lg:flex-1">
            <a href="{{ route('Home.home') }}" class="-m-1.5 p-1.5">
                <img class="h-auto w-70" src="{{ asset('pics/logo_text.png') }}" alt="Logo">
            </a>
        </div>

        {{-- menu tengah --}}
        <div class="hidden lg:flex lg:gap-x-10 text-white text-sm/6 font-semibold">
            <a href="{{ route('Home.home') }}" class="hover:text-blue-400">HOME</a>
            <a href="{{ route('Home.sermons') }}" class="hover:text-blue-400">SERMONS</a>
            <a href="{{ route('Home.articles') }}" class="hover:text-blue-400">ARTICLE</a>
            <a href="{{ route('Home.devotions') }}" class="hover:text-blue-400">DEVOTION</a>
            @auth
                <a href="{{ route('Dashboard.index') }}" class="hover:text-blue-400">ACCOUNT</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-blue-400" target="_blank">LOGIN</a>
            @endauth
        </div>

        {{-- icon kanan --}}
        <div class="hidden lg:flex flex-1 justify-end items-center space-x-3">
            <a href="https://www.instagram.com/bukitzion/" target="_blank">
                <img src="{{ asset('pics/Instagram Icon.png') }}" alt="Instagram" class="w-[18px] h-auto">
            </a>
            <a href="http://www.youtube.com/bukitzion" target="_blank">
                <img src="{{ asset('pics/Youtube Icon.png') }}" alt="YouTube" class="w-[18px] h-auto">
            </a>
        </div>

        {{-- burger untuk mobile --}}
        <div class="flex lg:hidden">
            <button type="button"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-white hover:text-blue-400"
                @click="isOpen = !isOpen">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </nav>


    {{-- mobile view --}}
    <div class="lg:hidden" x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
        x-transition:leave="transition ease-in duration-75 transform" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-10"></div>
        <div
            class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-[#31333B] px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="{{ route('Home.home') }}" class="-m-1.5 p-1.5">
                    <img class="h-15 w-auto" src="{{ asset('pics/logo_pic.png') }}" alt="Logo">
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-white hover:text-blue-400"
                    @click="isOpen = !isOpen">
                    <span class="sr-only">Close menu</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <div class="-mx-3 font-semibold text-white">
                            <a href="{{ route('Home.home') }}"
                                class="hover:text-blue-400 block rounded-lg px-3 py-2">HOME</a>
                            <a href="{{ route('Home.sermons') }}"
                                class="hover:text-blue-400 block rounded-lg px-3 py-2">SERMONS</a>
                            <a href="{{ route('Home.articles') }}"
                                class="hover:text-blue-400 block rounded-lg px-3 py-2">ARTICLE</a>
                            <a href="{{ route('Home.devotions') }}"
                                class="hover:text-blue-400 block rounded-lg px-3 py-2">DEVOTION</a>
                        </div>
                        <div class="py-6">
                            @auth
                                <a href="{{ route('Dashboard.index') }}"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:underline hover:text-blue-400">ACCOUNT</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:underline hover:text-blue-400">LOGIN</a>
                            @endauth
                        </div>

                        <!-- Social Media Icons -->
                        <div class="flex items-center space-x-3">
                            <a href="https://www.instagram.com/bukitzion/" target="_blank">
                                <img src="{{ asset('pics/Instagram Icon.png') }}" alt="Instagram"
                                    class="w-[18px] h-auto">
                            </a>
                            <a href="http://www.youtube.com/bukitzion" target="_blank">
                                <img src="{{ asset('pics/Youtube Icon.png') }}" alt="YouTube"
                                    class="w-[18px] h-auto">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</header>
