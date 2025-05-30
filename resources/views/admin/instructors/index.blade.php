<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Instructeurs</h1>
            
        </div>

        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Telefoonnummer</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nummer</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($instructors as $instructor)
                    <tr>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.instructors.show', $instructor) }}" class="text-blue-600 hover:underline">
                                {{ $instructor->user->name }}
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $instructor->user->email }}</td>
                        <td class="px-4 py-2">{{ $instructor->user->contact->mobile ?? 'Niet opgegeven' }}</td>
                        <td class="px-4 py-2">{{ $instructor->number }}</td>
                       
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.instructors.edit', $instructor) }}"
                                class="inline-flex items-center px-3 py-1 bg-amber-600 text-white rounded hover:bg-amber-700 transition text-sm"
                                style="background-color: #d97706;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3z" />
                                </svg>
                                Bewerken
                            </a>
                            <form action="{{ route('admin.instructors.destroy', $instructor) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="delete-instructor-btn inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Verwijderen
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if(count($instructors) === 0)
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                Geen instructeurs gevonden
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add SweetAlert2 via CDN just before </body> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-instructor-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = btn.closest('form');
                    Swal.fire({
                        title: 'Weet je het zeker?',
                        text: "Deze instructeur zal worden gedeactiveerd!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626', // Tailwind red-600
                        cancelButtonColor: '#6b7280', // Tailwind gray-500
                        confirmButtonText: 'Ja, verwijder!',
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
            });
        });
    </script>
</x-app-layout>
