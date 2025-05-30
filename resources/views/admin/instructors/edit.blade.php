<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Bewerk Instructeur</h1>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form action="{{ route('admin.instructors.update', $instructor) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Persoonlijke Informatie</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">Voornaam</label>
                            <input type="text" name="firstname" id="firstname" 
                                value="{{ old('firstname', $instructor->user->firstname) }}" required
                                class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('firstname')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="infix" class="block text-sm font-medium text-gray-700 mb-1">Tussenvoegsel</label>
                            <input type="text" name="infix" id="infix" 
                                value="{{ old('infix', $instructor->user->infix) }}"
                                class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('infix')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Achternaam</label>
                        <input type="text" name="lastname" id="lastname" 
                            value="{{ old('lastname', $instructor->user->lastname) }}" required
                            class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('lastname')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" 
                            value="{{ old('email', $instructor->user->email) }}" required
                            class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Geboortedatum</label>
                        <input type="date" name="birthdate" id="birthdate" 
                            value="{{ old('birthdate', $instructor->user->birthdate ? date('Y-m-d', strtotime($instructor->user->birthdate)) : '') }}"
                            class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('birthdate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Contactgegevens</h2>
                    
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Telefoonnummer</label>
                        <input type="text" name="mobile" id="mobile" 
                            value="{{ old('mobile', $instructor->user->contact->mobile ?? '') }}"
                            class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('mobile')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <div class="col-span-2">
                            <label for="street_name" class="block text-sm font-medium text-gray-700 mb-1">Straat</label>
                            <input type="text" name="street_name" id="street_name" 
                                value="{{ old('street_name', $instructor->user->contact->street_name ?? '') }}"
                                class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('street_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="house_number" class="block text-sm font-medium text-gray-700 mb-1">Huisnummer</label>
                            <div class="flex gap-2">
                                <input type="text" name="house_number" id="house_number" 
                                    value="{{ old('house_number', $instructor->user->contact->house_number ?? '') }}"
                                    class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <input type="text" name="addition" id="addition" 
                                    placeholder="Toev." 
                                    value="{{ old('addition', $instructor->user->contact->addition ?? '') }}"
                                    class="w-1/3 rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                            @error('house_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postcode</label>
                            <input type="text" name="postal_code" id="postal_code" 
                                value="{{ old('postal_code', $instructor->user->contact->postal_code ?? '') }}"
                                class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('postal_code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="col-span-2">
                            <label for="place" class="block text-sm font-medium text-gray-700 mb-1">Plaats</label>
                            <input type="text" name="place" id="place" 
                                value="{{ old('place', $instructor->user->contact->place ?? '') }}"
                                class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('place')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Instructeur Gegevens</h2>
                    
                    <div>
                        <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Instructeur nummer</label>
                        <input type="text" name="number" id="number" 
                            value="{{ old('number', $instructor->number) }}"
                            class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="is_active" id="is_active" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="1" {{ old('is_active', $instructor->user->is_active) ? 'selected' : '' }}>Actief</option>
                            <option value="0" {{ old('is_active', $instructor->user->is_active) ? '' : 'selected' }}>Inactief</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.instructors.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                        Annuleren
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
