<!--TODO: buat previous post-->

<x-layout_home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
            <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue">
                <header class="mb-4 lg:mb-6 not-format">
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl">
                        <address class="flex items-center mb-6 not-italic">
                            {{ $rangkuman->judul_rangkuman }}
                    </h1>
                    <div class="inline-flex items-center mr-3 text-sm text-gray-900">

                        <div>
                            <p class="text-xl font-bold text-gray-900">{{ $rangkuman->nama_narasumber }}</p>
                            <p class="text-base text-gray-500">Ditulis Oleh:
                                {{ $rangkuman->pelayan->jemaat->nama_jemaat }}</p>
                            <p class="text-base text-gray-500">
                                {{ \Carbon\Carbon::parse($rangkuman->tgl_rangkuman)->diffForHumans() }}</p>
                        </div>
                    </div>
                    </address>
                </header>
                <figure>
                    @if ($rangkuman->gambar_rangkuman)
                        <img src="{{ asset('storage/' . $rangkuman->gambar_rangkuman) }}" alt="Gambar Rangkuman"
                            class="w-full object-cover rounded-md mb-4 p-1 bg-white">
                    @else
                        <img src="{{ asset('pics/placeholder.webp') }}" alt="Placeholder"
                            class="w-full object-cover rounded-md mb-4 p-1 bg-white">
                    @endif
                </figure>
                <p>{!! $rangkuman->isi_rangkuman !!}</p>
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center font-medium text-primary-600 hover:underline mt-5">
                    <svg class="w-5 h-5 font-semibold" viewBox="0 0 512 512" data-name="Layer 1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M34,256,210,80l21.21,21.2L91.4,241H478v30H91.4L231.25,410.84,210,432Z" />
                    </svg>
                    Kembali
                </a>
            </article>
        </div>
    </main>
</x-layout_home>
