<x-app-layout>
    <div class="max-w-xl mx-auto py-8">
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Student bewerken: {{ $student->user->name }}</h2>
            <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $student->user_id }}">
                
                <div>
                    <h3 class="font-semibold mb-2 text-gray-700">Persoonlijke gegevens</h3>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Voornaam</label>
                        <input type="text" name="firstname" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('firstname', $student->user->firstname ?? '') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Tussenvoegsel</label>
                        <input type="text" name="infix" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" value="{{ old('infix', $student->user->infix ?? '') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Achternaam</label>
                    <input type="text" name="lastname" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('lastname', $student->user->lastname ?? '') }}">
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-1">E-mail</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('email', $student->user->email ?? '') }}">
                </div>

                <!-- Keep the role dropdown for administrators -->
                @if(Auth::user()->Roles()->where('name', 'Administrator')->exists())
                <div>
                    <label class="block text-gray-700 mb-1">Rol</label>
                    <select name="role" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        @foreach($roles as $role)
                            <option value="{{ $role }}" @if(old('role', $student->user->roles->where('isactive', true)->first()->name ?? '') == $role) selected @endif>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div>
                    <h3 class="font-semibold mb-2 text-gray-700 pt-4">Contactgegevens</h3>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Straatnaam</label>
                        <input type="text" name="contact_street_name" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_street_name', $student->user->contact->street_name ?? '') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Huisnummer</label>
                        <input type="text" name="contact_house_number" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_house_number', $student->user->contact->house_number ?? '') }}">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Toevoeging</label>
                        <input type="text" name="contact_addition" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_addition', $student->user->contact->addition ?? '') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Postcode</label>
                        <input type="text" name="contact_postal_code" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_postal_code', $student->user->contact->postal_code ?? '') }}">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Plaats</label>
                    <input type="text" name="contact_place" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('contact_place', $student->user->contact->place ?? '') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Mobiel</label>
                    <input type="text" name="contact_mobile" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('contact_mobile', $student->user->contact->mobile ?? '') }}">
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2 text-gray-700 pt-4">Student gegevens</h3>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-1">Relatienummer</label>
                    <input type="text" name="relation_number" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('relation_number', $student->relation_number) }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Status</label>
                    <select name="isactive" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" {{ old('isactive', $student->isactive) ? 'selected' : '' }}>Actief</option>
                        <option value="0" {{ !old('isactive', $student->isactive) ? 'selected' : '' }}>Inactief</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Opmerking</label>
                    <textarea name="remark" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" rows="3">{{ old('remark', $student->remark) }}</textarea>
                </div>
                <div class="flex justify-between mt-6">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Bijwerken</button>
                    <a href="{{ route('students.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Annuleren</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>