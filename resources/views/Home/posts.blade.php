<x-layout_home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <section class="bg-white">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="grid gap-8 lg:grid-cols-4 sm:grid-cols-2">
                @foreach ($rangkuman as $_rangkuman)
                    <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md">
                        <div class="flex justify-between items-center mb-5 text-gray-500">
                            <span
                                class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded ">
                                @if (isset($_rangkuman->kategori_sermons))
                                    <a class="hover:underline"
                                        href="{{ route('Home.sermons_categories', $_rangkuman->kategori_sermons) }}">
                                        {{ $_rangkuman->kategori_sermons }}
                                    </a>
                                @endif
                            </span>
                            <span
                                class="text-sm">{{ \Carbon\Carbon::parse($_rangkuman->tgl_rangkuman)->diffForHumans() }}</span>
                        </div>
                        @if ($_rangkuman->gambar_rangkuman)
                            <img src="{{ asset('storage/' . $_rangkuman->gambar_rangkuman) }}" alt="Gambar Rangkuman"
                                class="w-full h-40 object-cover rounded-md mb-4 p-1 bg-white">
                        @else
                            <img src="{{ asset('pics/placeholder.webp') }}" alt="Placeholder"
                                class="w-full h-40 object-cover rounded-md mb-4 p-1 bg-white">
                        @endif
                        <h2 class="mb-2 text-lg font-bold tracking-tight text-gray-900 hover:underline"><a
                                href="#">{{ $_rangkuman->judul_rangkuman }}</a></h2>
                        <p>
                            {!! \Illuminate\Support\Str::limit($_rangkuman->isi_rangkuman, 100, $end = '...') !!}
                        </p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4 mt-5">
                                <span class="font-semibold">
                                    {{ $_rangkuman->nama_narasumber }}
                                </span>
                            </div>
                            <a href="{{ route('Home.single_post', $_rangkuman->slug_rangkuman) }}"
                                class="inline-flex items-center font-medium text-primary-600 hover:underline mt-5">
                                Read more
                                <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layout_home>
