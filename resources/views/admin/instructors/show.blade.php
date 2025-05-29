<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Instructeur Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.instructors.edit', $instructor) }}"
                    class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3z" />
                    </svg>
                    Bewerken
                </a>

                <form action="{{ route('admin.instructors.destroy', $instructor) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="delete-instructor-btn"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Verwijderen
                    </button>
                </form>
                
                <a href="{{ route('admin.instructors.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Terug
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-6 p-6">
                <!-- Personal Information -->
                <div class="bg-white p-4 rounded-lg border">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Persoonlijke Informatie</h2>
                    <dl class="space-y-2">
                        <div class="grid grid-cols-2">
                            <dt class="font-medium text-gray-600">Naam:</dt>
                            <dd>{{ $instructor->user->name }}</dd>
                        </div>
                        <div class="grid grid-cols-2">
                            <dt class="font-medium text-gray-600">Voornaam:</dt>
                            <dd>{{ $instructor->user->firstname }}</dd>
                        </div>
                        @if($instructor->user->infix)
                            <div class="grid grid-cols-2">
                                <dt class="font-medium text-gray-600">Tussenvoegsel:</dt>
                                <dd>{{ $instructor->user->infix }}</dd>
                            </div>
                        @endif
                        <div class="grid grid-cols-2">
                            <dt class="font-medium text-gray-600">Achternaam:</dt>
                            <dd>{{ $instructor->user->lastname }}</dd>
                        </div>
                        <div class="grid grid-cols-2">
                            <dt class="font-medium text-gray-600">E-mail:</dt>
                            <dd>{{ $instructor->user->email }}</dd>
                        </div>
                        <div class="grid grid-cols-2">
                            <dt class="font-medium text-gray-600">Geboortedatum:</dt>
                            <dd>{{ $instructor->user->birthdate ? \Carbon\Carbon::parse($instructor->user->birthdate)->format('d-m-Y') : 'Niet opgegeven' }}</dd>
                        </div>
                        <div class="grid grid-cols-2">
                            <dt class="font-medium text-gray-600">Status:</dt>
                            <dd>
                                @if($instructor->user->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Actief</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Inactief</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Contact Information -->
                <div class="bg-white p-4 rounded-lg border">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Contactgegevens</h2>
                    <dl class="space-y-2">
                        @if($instructor->user->contact)
                            @if($instructor->user->contact->street_name)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Adres:</dt>
                                    <dd>
                                        {{ $instructor->user->contact->street_name }} 
                                        {{ $instructor->user->contact->house_number }}
                                        {{ $instructor->user->contact->addition }}
                                    </dd>
                                </div>
                            @endif
                            @if($instructor->user->contact->postal_code)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Postcode:</dt>
                                    <dd>{{ $instructor->user->contact->postal_code }}</dd>
                                </div>
                            @endif
                            @if($instructor->user->contact->place)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Woonplaats:</dt>
                                    <dd>{{ $instructor->user->contact->place }}</dd>
                                </div>
                            @endif
                            @if($instructor->user->contact->mobile)
                                <div class="grid grid-cols-2">
                                    <dt class="font-medium text-gray-600">Telefoonnummer:</dt>
                                    <dd>{{ $instructor->user->contact->mobile }}</dd>
                                </div>
                            @endif
                        @else
                            <div class="text-gray-500 italic">Geen contactgegevens opgegeven</div>
                        @endif
                    </dl>
                </div>

                <!-- Instructor Information -->
                <div class="bg-white p-4 rounded-lg border">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Instructeur Informatie</h2>
                    <dl class="space-y-2">
                        <div class="grid grid-cols-2">
                            <dt class="font-medium text-gray-600">Instructeur nummer:</dt>
                            <dd>{{ $instructor->number ?? 'Niet opgegeven' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    {{-- Add SweetAlert2 via CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteBtn = document.getElementById('delete-instructor-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    
                    Swal.fire({
                        title: 'Weet je het zeker?',
                        text: "Deze instructeur zal worden gedeactiveerd!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626', // Tailwind red-600
                        cancelButtonColor: '#6b7280', // Tailwind gray-500
                        confirmButtonText: 'Ja, deactiveren!',
                        cancelButtonText: 'Annuleren',
                        customClass: {
                            popup: 'rounded-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>
