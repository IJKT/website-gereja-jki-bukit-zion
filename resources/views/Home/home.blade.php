<x-layout_home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <section class="relative text-white py-20 px-4">
        <!-- Background -->
        <div class="absolute inset-0">
            <img src="{{ asset('pics/DSC07426.jpg') }}" alt="Background" class="w-full h-[90vh] object-cover opacity-50">
        </div>

        <div class="relative z-10 max-w-6xl mx-auto">
            <!-- Black header background for "OUR SERVICE" -->
            <div class="bg-black/90 py-6 text-center rounded-md mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-orange-600">OUR SERVICE</h2>
            </div>

            <!-- Semi-transparent background for the schedule grid -->
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
