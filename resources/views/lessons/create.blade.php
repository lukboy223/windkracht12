<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Les inplannen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold mb-6 text-[#1B4965]">Nieuwe les inplannen</h3>
                    
                    <form action="{{ route('lessons.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="registration_id" value="Registratie" />
                            <select id="registration_id" name="registration_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Selecteer een registratie</option>
                                @foreach($registrations as $registration)
                                    <option value="{{ $registration->id }}" {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                                        {{ $registration->student->user->name }} - 
                                        {{ \App\Models\Package::find($registration->package_id)->name ?? 'Onbekend pakket' }} - 
                                        Nog {{ $registration->remaining_lessons }} lessen
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('registration_id')" class="mt-2" />
                            
                            <div id="no-lessons-warning" class="hidden mt-2 p-2 bg-yellow-100 text-yellow-800 rounded text-sm">
                                Let op: Deze registratie heeft geen lessen meer over. Plan alleen een nieuwe les in als er een extra les is afgesproken.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="start_date" value="Datum" />
                            <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="start_time" value="Tijd" />
                            <select id="start_time" name="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="09:00:00" {{ old('start_time') == '09:00:00' ? 'selected' : '' }}>Ochtend (9:00)</option>
                                <option value="13:00:00" {{ old('start_time') == '13:00:00' ? 'selected' : '' }}>Middag (13:00)</option>
                            </select>
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>
                        
                        <div class="mb-4">
                            <x-input-label for="remark" value="Opmerking" />
                            <textarea id="remark" name="remark" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('remark') }}</textarea>
                            <x-input-error :messages="$errors->get('remark')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('lessons.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Annuleren
                            </a>
                            <x-primary-button>
                                Les inplannen
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Show warning when selecting a registration with no lessons remaining
        document.getElementById('registration_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const warningElement = document.getElementById('no-lessons-warning');
            
            if (selectedOption && selectedOption.text.includes('Nog 0 lessen')) {
                warningElement.classList.remove('hidden');
            } else {
                warningElement.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
