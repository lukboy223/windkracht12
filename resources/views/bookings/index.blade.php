<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kies je lespakket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-serif text-2xl md:text-3xl my-4 text-[#1B4965]">Beschikbare lespakketten</h3>
                    <p class="mb-8 text-gray-600">Kies één van onze lespakketten om te boeken</p>

                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($packages as $package)
                            <div class="bg-[#FFFCEA] rounded-2xl shadow-lg h-min transition-transform hover:scale-105">
                                <h4 class="w-full text-2xl text-center my-4 font-semibold text-[#1B4965]">{{ $package['name'] }}</h4>
                                <div class="bg-[#FFF8D0] w-full p-4 rounded-b-xl">
                                    <ul class="list-disc mx-auto w-2/3 text-xl text-[#22223b]">
                                        @foreach($package['features'] as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                    <p class="w-full text-center text-2xl mt-4 font-bold text-[#1B4965]">€{{ $package['price'] }},- pp</p>
                                </div>
                                <div class="my-4 flex justify-center">
                                    <a href="{{ route('bookings.create', $package['id']) }}"
                                        class="bg-[#95E794] hover:bg-[#6fcf97] transition-colors p-2 px-6 text-xl rounded-full shadow font-semibold">
                                        Boeken
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
