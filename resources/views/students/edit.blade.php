<x-app-layout>
    <div class="max-w-xl mx-auto py-8">
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Student</h2>
            <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-gray-700 mb-1">User</label>
                    <select name="user_id" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if(old('user_id', $student->user_id) == $user->id) selected @endif>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Name</label>
                    <input type="text" name="user_name" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('user_name', $student->user->name ?? '') }}">
                </div>
                @if(Auth::user()->Roles()->where('name', 'Administrator')->exists())
                <div>
                    <label class="block text-gray-700 mb-1">Role</label>
                    <select name="role" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        @foreach($roles as $role)
                            <option value="{{ $role }}" @if(old('role', $student->user->role->name ?? '') == $role) selected @endif>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Street Name</label>
                        <input type="text" name="contact_street_name" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_street_name', $student->user->contact->street_name ?? '') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">House Number</label>
                        <input type="text" name="contact_house_number" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_house_number', $student->user->contact->house_number ?? '') }}">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Addition</label>
                        <input type="text" name="contact_addition" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_addition', $student->user->contact->addition ?? '') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Postal Code</label>
                        <input type="text" name="contact_postal_code" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('contact_postal_code', $student->user->contact->postal_code ?? '') }}">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Place</label>
                    <input type="text" name="contact_place" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('contact_place', $student->user->contact->place ?? '') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Mobile</label>
                    <input type="text" name="contact_mobile" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('contact_mobile', $student->user->contact->mobile ?? '') }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Relation Number</label>
                    <input type="text" name="relation_number" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required value="{{ old('relation_number', $student->relation_number) }}">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Active</label>
                    <select name="isactive" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" {{ old('isactive', $student->isactive) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !old('isactive', $student->isactive) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Remark</label>
                    <textarea name="remark" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" rows="3">{{ old('remark', $student->remark) }}</textarea>
                </div>
                <div class="flex justify-between mt-6">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Update</button>
                    <a href="{{ route('students.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>