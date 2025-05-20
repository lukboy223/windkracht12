<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vul je BSN in om je account te voltooien
        </h2>
    </x-slot>
    <div class="max-w-xl mx-auto py-8">
        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('instructors.bsn.save', $instructor->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-1">BSN Nummer</label>
                    <input type="text" name="bsn" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('bsn', $instructor->bsn ?? '') }}">
                    @error('bsn')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
