<x-app-layout>
    <div class="max-w-xl mx-auto py-8">
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Student</h2>
            <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-1">First Name</label>
                    <input type="text" name="user_firstname" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('user_firstname') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="user_lastname" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('user_lastname') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Email</label>
                    <input type="email" name="user_email" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('user_email') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="user_password" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Birthdate</label>
                    <input type="date" name="user_birthdate" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('user_birthdate') }}">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Street Name</label>
                        <input type="text" name="contact_street_name" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" value="{{ old('contact_street_name') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">House Number</label>
                        <input type="text" name="contact_house_number" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" value="{{ old('contact_house_number') }}">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Addition</label>
                        <input type="text" name="contact_addition" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" value="{{ old('contact_addition') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Postal Code</label>
                        <input type="text" name="contact_postal_code" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" value="{{ old('contact_postal_code') }}">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Place</label>
                    <input type="text" name="contact_place" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" value="{{ old('contact_place') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Mobile</label>
                    <input type="text" name="contact_mobile" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" value="{{ old('contact_mobile') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Relation Number</label>
                    <input type="text" name="relation_number" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('relation_number') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Active</label>
                    <select name="isactive" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" {{ old('isactive', 1) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('isactive') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Remark</label>
                    <textarea name="remark" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" rows="3">{{ old('remark') }}</textarea>
                </div>
                <div class="flex justify-between mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Create</button>
                    <a href="{{ route('students.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
