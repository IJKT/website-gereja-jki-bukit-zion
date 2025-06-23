<x-layout_home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <section class="text-white py-20 px-4">
        <!-- Background Layer -->
        <div class="fixed top-0 left-0 w-full h-full -z-10">
            <img src="{{ asset('pics/DSC07426.jpg') }}" alt="Background" class="w-full h-full object-cover" />
            <div class="absolute inset-0"></div>
        </div>

        <!-- Foreground Content -->
        <div class="max-w-6xl mx-auto">
            <!-- Black header -->
            <div class="bg-black py-6 text-center rounded-md mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-orange-600">OUR SERVICE</h2>
            </div>

            <!-- Schedule grid -->
            <div class="bg-black/60 p-6 rounded-md grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 text-center">
                <!-- Sunday Service -->
                <div>
                    <h3 class="text-2xl font-bold text-orange-500 mb-2">SUNDAY SERVICE</h3>
                    <p class="italic text-lg">Sunday, 09.00 WIB</p>
                </div>

                <!-- Shabbat Fellowship -->
                <div>
                    <h3 class="text-2xl font-bold text-orange-500 mb-2">SHABBAT FELLOWSHIP</h3>
                    <p class="italic text-lg">Friday, 18.30 WIB</p>
                </div>

                <!-- Kabuzi Service -->
                <div>
                    <h3 class="text-2xl font-bold text-orange-500 mb-2">KABUZI SERVICE</h3>
                    <p class="italic text-lg text-white/70">COMING SOON</p>
                </div>

                <!-- Sunday School -->
                <div>
                    <h3 class="text-2xl font-bold text-orange-500 mb-2">SUNDAY SCHOOL</h3>
                    <p class="italic text-lg">Sunday, 09.00 WIB</p>
                </div>

                <!-- Shabbat Service -->
                <div>
                    <h3 class="text-2xl font-bold text-orange-500 mb-2">SHABBAT SERVICE</h3>
                    <p class="italic text-lg">Saturday, 10.00 WIB</p>
                </div>
            </div>
        </div>
    </section>

</x-layout_home>
