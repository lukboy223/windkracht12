<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boek je les') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold mb-6 text-[#1B4965]">{{ $package['name'] }} boeken</h3>
                    
                    <div class="mb-8 p-4 bg-[#FFFCEA] rounded-xl">
                        <h4 class="text-xl font-medium mb-2">Details pakket:</h4>
                        <ul class="mb-2">
                            <li><span class="font-medium">Duur:</span> {{ $package['duration'] }}</li>
                            <li><span class="font-medium">Prijs:</span> €{{ $package['price'] }},-</li>
                        </ul>
                        <p>{{ $package['description'] }}</p>
                    </div>

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $id }}">
                        
                        @if(strpos($id, 'duo-three') !== false || strpos($id, 'duo-five') !== false)
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="font-medium text-blue-800 mb-2">
                                    <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Meerdere lessen plannen
                                </h4>
                                <p class="text-sm text-blue-700 mb-2">
                                    Dit pakket bevat {{ strpos($id, 'duo-three') !== false ? '3' : '5' }} lessen. 
                                    Na het boeken van de eerste les kun je de volgende lessen plannen in overleg met je instructeur.
                                </p>
                                <p class="text-sm text-blue-700">
                                    De eerste les wordt nu gepland. De overige lessen worden later ingepland.
                                </p>
                            </div>
                        @endif
                        
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Gewenste datum')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="time" :value="__('Voorkeurstijd')" />
                            <select id="time" name="time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="morning" {{ old('time') == 'morning' ? 'selected' : '' }}>Ochtend (9:00 - 12:30)</option>
                                <option value="afternoon" {{ old('time') == 'afternoon' ? 'selected' : '' }}>Middag (13:00 - 16:30)</option>
                            </select>
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Locatie')" />
                            <select id="location" name="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="Zandvoort" {{ old('location') == 'Zandvoort' ? 'selected' : '' }}>Zandvoort</option>
                                <option value="Muiderberg" {{ old('location') == 'Muiderberg' ? 'selected' : '' }}>Muiderberg</option>
                                <option value="Wijk aan Zee" {{ old('location') == 'Wijk aan Zee' ? 'selected' : '' }}>Wijk aan Zee</option>
                                <option value="IJmuiden" {{ old('location') == 'IJmuiden' ? 'selected' : '' }}>IJmuiden</option>
                                <option value="Scheveningen" {{ old('location') == 'Scheveningen' ? 'selected' : '' }}>Scheveningen</option>
                                <option value="Hoek van Holland" {{ old('location') == 'Hoek van Holland' ? 'selected' : '' }}>Hoek van Holland</option>
                            </select>
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="participants" :value="__('Aantal deelnemers')" />
                            <select id="participants" name="participants" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="1" {{ old('participants') == 1 ? 'selected' : '' }}>1 persoon</option>
                                @if($id !== 'private')
                                <option value="2" {{ old('participants') == 2 ? 'selected' : '' }}>2 personen</option>
                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('participants')" class="mt-2" />
                        </div>
                        
                        <div id="partner-field" class="mb-4 {{ old('participants') == 2 ? '' : 'hidden' }}">
                            <x-input-label for="partner_name" :value="__('Naam van je partner')" />
                            <x-text-input id="partner_name" class="block mt-1 w-full" type="text" name="partner_name" :value="old('partner_name')" />
                            <x-input-error :messages="$errors->get('partner_name')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="notes" :value="__('Opmerkingen')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Annuleren
                            </a>
                            <x-primary-button>
                                {{ __('Boeken') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('participants').addEventListener('change', function() {
            const partnerField = document.getElementById('partner-field');
            if (this.value === '2') {
                partnerField.classList.remove('hidden');
            } else {
                partnerField.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
