<x-app-layout>
    <div class="py-8 px-4 max-w-5xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="border-b bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Student Gegevens</h1>
                <div class="space-x-2">
                    <a href="{{ route('students.edit', $student) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">Bewerken</a>
                    <a href="{{ route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition">Terug</a>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-white p-4 rounded-lg border">
                        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Persoonlijke Informatie</h2>
                        <dl class="space-y-2">
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Naam:</dt>
                                <dd>{{ $student->user->name }}</dd>
                            </div>
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Voornaam:</dt>
                                <dd>{{ $student->user->firstname }}</dd>
                            </div>
                            @if($student->user->infix)
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Tussenvoegsel:</dt>
                                <dd>{{ $student->user->infix }}</dd>
                            </div>
                            @endif
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Achternaam:</dt>
                                <dd>{{ $student->user->lastname }}</dd>
                            </div>
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">E-mail:</dt>
                                <dd>{{ $student->user->email }}</dd>
                            </div>
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Geboortedatum:</dt>
                                <dd>{{ $student->user->birthdate ? \Carbon\Carbon::parse($student->user->birthdate)->format('d-m-Y') : 'Niet opgegeven' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white p-4 rounded-lg border">
                        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Contactgegevens</h2>
                        <dl class="space-y-2">
                            @if($student->user->contact)
                                @if($student->user->contact->street_name)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Adres:</dt>
                                    <dd>
                                        {{ $student->user->contact->street_name }} 
                                        {{ $student->user->contact->house_number }}
                                        {{ $student->user->contact->addition }}
                                    </dd>
                                </div>
                                @endif
                                @if($student->user->contact->postal_code)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Postcode:</dt>
                                    <dd>{{ $student->user->contact->postal_code }}</dd>
                                </div>
                                @endif
                                @if($student->user->contact->place)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Woonplaats:</dt>
                                    <dd>{{ $student->user->contact->place }}</dd>
                                </div>
                                @endif
                                @if($student->user->contact->mobile)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Telefoonnummer:</dt>
                                    <dd>{{ $student->user->contact->mobile }}</dd>
                                </div>
                                @endif
                            @else
                                <div class="text-gray-500 italic">Geen contactgegevens opgegeven</div>
                            @endif
                        </dl>
                    </div>
                    
                    <!-- Student Information -->
                    <div class="bg-white p-4 rounded-lg border">
                        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Student Informatie</h2>
                        <dl class="space-y-2">
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Relatienummer:</dt>
                                <dd>{{ $student->relation_number }}</dd>
                            </div>
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Status:</dt>
                                <dd>
                                    @if($student->isactive)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Actief</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Inactief</span>
                                    @endif
                                </dd>
                            </div>
                            @if($student->remark)
                                <div class="col-span-2">
                                    <dt class="font-medium text-gray-600">Opmerking:</dt>
                                    <dd class="mt-1 whitespace-pre-wrap">{{ $student->remark }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                    
                    <!-- Registrations and Lessons -->
                    <div class="bg-white p-4 rounded-lg border">
                        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Lespakketten</h2>
                        @if($student->registrations && $student->registrations->count() > 0)
                            <div class="space-y-4">
                                @foreach($student->registrations as $registration)
                                    <div class="p-3 border rounded-lg">
                                        <h3 class="font-semibold">
                                            @php
                                                $package = \App\Models\Package::find($registration->package_id);
                                            @endphp
                                            {{ $package ? $package->name : 'Onbekend pakket' }}
                                        </h3>
                                        <div class="text-sm text-gray-600">
                                            Start datum: {{ \Carbon\Carbon::parse($registration->start_date)->format('d-m-Y') }}
                                        </div>
                                        @if($registration->end_date)
                                            <div class="text-sm text-gray-600">
                                                Eind datum: {{ \Carbon\Carbon::parse($registration->end_date)->format('d-m-Y') }}
                                            </div>
                                        @endif
                                        @if(isset($registration->remaining_lessons))
                                            <div class="text-sm text-gray-600">
                                                Resterende lessen: {{ $registration->remaining_lessons }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500 italic">Geen lespakketten gevonden</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
