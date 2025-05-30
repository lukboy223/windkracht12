<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($isAdmin) && $isAdmin ? 'Alle lessen beheer' : 'Alle lessen' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">
                        @if(isset($isAdmin) && $isAdmin)
                            Overzicht van alle lessen in het systeem
                        @else
                            Overzicht van al je lessen
                        @endif
                    </h3>
                    
                    @if(!$isStudent)
                    <a href="{{ route('lessons.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Nieuwe les inplannen
                    </a>
                    @endif
                </div>
                
                <!-- Filter options -->
                <div x-data="{ showFilters: false }" class="mb-4">
                    <button @click="showFilters = !showFilters" class="mb-2 flex items-center text-blue-600 hover:text-blue-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span x-text="showFilters ? 'Verberg filters' : 'Toon filters'"></span>
                    </button>
                    
                    <div x-show="showFilters" x-transition class="mt-2">
                        <form action="{{ route('lessons.index') }}" method="GET" class="p-4 bg-gray-50 rounded-md grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Period filter -->
                            <div>
                                <label for="period" class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                                <select id="period" name="period" class="w-full rounded-md border-gray-300">
                                    <option value="">Alle periodes</option>
                                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Vandaag</option>
                                    <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>Deze week</option>
                                    <option value="next_week" {{ request('period') == 'next_week' ? 'selected' : '' }}>Volgende week</option>
                                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Deze maand</option>
                                </select>
                            </div>
                        
                            <!-- Status filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="status" name="status" class="w-full rounded-md border-gray-300">
                                    <option value="">Alle statussen</option>
                                    <option value="Planned" {{ request('status') == 'Planned' ? 'selected' : '' }}>Gepland</option>
                                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Voltooid</option>
                                    <option value="Canceled" {{ request('status') == 'Canceled' ? 'selected' : '' }}>Geannuleerd</option>
                                    <option value="Awaiting payment" {{ request('status') == 'Awaiting payment' ? 'selected' : '' }}>Wacht op betaling</option>
                                </select>
                            </div>
                        
                            <!-- Location filter -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Locatie</label>
                                <select id="location" name="location" class="w-full rounded-md border-gray-300">
                                    <option value="">Alle locaties</option>
                                    <option value="Zandvoort" {{ request('location') == 'Zandvoort' ? 'selected' : '' }}>Zandvoort</option>
                                    <option value="Muiderberg" {{ request('location') == 'Muiderberg' ? 'selected' : '' }}>Muiderberg</option>
                                    <option value="Wijk aan Zee" {{ request('location') == 'Wijk aan Zee' ? 'selected' : '' }}>Wijk aan Zee</option>
                                    <option value="IJmuiden" {{ request('location') == 'IJmuiden' ? 'selected' : '' }}>IJmuiden</option>
                                    <option value="Scheveningen" {{ request('location') == 'Scheveningen' ? 'selected' : '' }}>Scheveningen</option>
                                    <option value="Hoek van Holland" {{ request('location') == 'Hoek van Holland' ? 'selected' : '' }}>Hoek van Holland</option>
                                </select>
                            </div>
                            
                            <!-- Additional filter for admin -->
                            @if(isset($isAdmin) && $isAdmin)
                            <div>
                                <label for="instructor" class="block text-sm font-medium text-gray-700 mb-1">Instructeur</label>
                                <select id="instructor" name="instructor_id" class="w-full rounded-md border-gray-300">
                                    <option value="">Alle instructeurs</option>
                                    @foreach(\App\Models\Instructor::with('user')->get() as $instructor)
                                        <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            
                            <div class="md:col-span-3 flex justify-end space-x-2">
                                <a href="{{ route('lessons.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                    Reset
                                </a>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Filter toepassen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if($lessons->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="py-2 px-4">Datum</th>
                                <th class="py-2 px-4">Tijd</th>
                                <th class="py-2 px-4">Status</th>
                                @if(isset($isAdmin) && $isAdmin)
                                    <th class="py-2 px-4">Instructeur</th>
                                    <th class="py-2 px-4">Student</th>
                                @else
                                    <th class="py-2 px-4">
                                        @if($isStudent)
                                        Instructeur
                                        @else
                                        Student
                                        @endif
                                    </th>
                                @endif
                                <th class="py-2 px-4">Pakket</th>
                                <th class="py-2 px-4">Locatie</th>
                                <th class="py-2 px-4">Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lessons as $lesson)
                            <tr class="border-t">
                                <td class="py-2 px-4">
                                    {{ \Carbon\Carbon::parse($lesson->start_date)->format('d-m-Y') }}
                                </td>
                                <td class="py-2 px-4">
                                    {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }}
                                </td>
                                <td class="py-2 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        @if($lesson->lesson_status == 'Planned') bg-blue-100 text-blue-800
                                        @elseif($lesson->lesson_status == 'Completed') bg-green-100 text-green-800
                                        @elseif($lesson->lesson_status == 'Canceled') bg-red-100 text-red-800
                                        @elseif($lesson->lesson_status == 'Awaiting payment') bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ $lesson->lesson_status }}
                                    </span>
                                </td>
                                
                                @if(isset($isAdmin) && $isAdmin)
                                    <td class="py-2 px-4">
                                        <a href="{{ route('admin.instructors.show', $lesson->instructor->id) }}" class="text-blue-600 hover:underline">
                                            {{ $lesson->instructor->user->name ?? '-' }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('students.show', $lesson->registration->student->id) }}" class="text-blue-600 hover:underline">
                                            {{ $lesson->registration->student->user->name ?? '-' }}
                                        </a>
                                    </td>
                                @else
                                    <td class="py-2 px-4">
                                        @if($isStudent)
                                        {{-- Show instructor name --}}
                                        <a href="{{ route('instructors.show', $lesson->instructor->id) }}" class="text-blue-600 hover:underline">
                                            {{ $lesson->instructor->user->name ?? '-' }}
                                        </a>
                                        @else
                                        {{-- Show student name --}}
                                        <a href="{{ route('students.show', $lesson->registration->student->id) }}" class="text-blue-600 hover:underline">
                                            {{ $lesson->registration->student->user->name ?? '-' }}
                                        </a>
                                        @endif
                                    </td>
                                @endif
                                
                                <td class="py-2 px-4">
                                    @if($lesson->registration && $lesson->registration->package_id)
                                        @php
                                            $package = \App\Models\Package::find($lesson->registration->package_id);
                                        @endphp
                                        @if($package)
                                            <span class="font-medium">{{ $package->name }}</span>
                                            <br>
                                            <span class="text-xs text-gray-500">{{ $package->duration }}</span>
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                
                                <td class="py-2 px-4">
                                    {{ $lesson->registration->booking->location ?? '-' }}
                                </td>
                                
                               
                                
                                <td class="py-2 px-4">
                                    @if($lesson->lesson_status !== 'Canceled')
                                    <button
                                        type="button"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-sm"
                                        onclick="openCancelModal('{{ $lesson->id }}')">
                                        Annuleer
                                    </button>
                                    @else
                                    <span
                                        class="inline-block px-3 py-1 rounded bg-gray-300 text-gray-600 text-sm cursor-not-allowed">Geannuleerd</span>
                                    @endif

                                    <!-- Cancel Modal -->
                                    <div id="cancel-modal-{{ $lesson->id }}" style="display: none;"
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                                            <h2 class="text-xl font-bold mb-4">Les annuleren</h2>
                                            <form method="POST" action="{{ route('lessons.cancel', $lesson->id) }}" id="cancel-form-{{ $lesson->id }}">
                                                @csrf
                                                <input type="hidden" name="reason" id="reason-input-{{ $lesson->id }}">
                                                
                                                <div class="mb-4">
                                                    <label class="block mb-2 font-semibold">Reden voor annulering:</label>
                                                    <div class="space-y-2 mb-3">
                                                        <div class="flex items-center">
                                                            <input type="radio" id="reason-sick-{{ $lesson->id }}" name="reason-option-{{ $lesson->id }}" value="Ziek/niet beschikbaar" 
                                                                onchange="updateReason('{{ $lesson->id }}', this.value)" class="mr-2">
                                                            <label for="reason-sick-{{ $lesson->id }}" class="cursor-pointer">Ziek/niet beschikbaar</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" id="reason-weather-{{ $lesson->id }}" name="reason-option-{{ $lesson->id }}" value="Slechte weersomstandigheden" 
                                                                onchange="updateReason('{{ $lesson->id }}', this.value)" class="mr-2">
                                                            <label for="reason-weather-{{ $lesson->id }}" class="cursor-pointer">Slechte weersomstandigheden</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" id="reason-other-{{ $lesson->id }}" name="reason-option-{{ $lesson->id }}" value="other" 
                                                                onchange="toggleCustomReason('{{ $lesson->id }}')" class="mr-2">
                                                            <label for="reason-other-{{ $lesson->id }}" class="cursor-pointer">Andere reden</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="custom-reason-{{ $lesson->id }}" style="display: none;">
                                                        <textarea id="custom-reason-text-{{ $lesson->id }}" class="w-full border rounded p-2" placeholder="Vul hier uw reden in..."></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" class="px-4 py-2 rounded bg-gray-200"
                                                        onclick="closeCancelModal('{{ $lesson->id }}')">Sluiten</button>
                                                    <button type="button" id="submit-btn-{{ $lesson->id }}"
                                                        onclick="submitCancelForm('{{ $lesson->id }}')"
                                                        class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600 opacity-50 cursor-not-allowed" disabled>
                                                        Annuleer les
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Add pagination links -->
                <div class="mt-4">
                    {{ $lessons->links() }}
                </div>
                @else
                <p class="text-gray-500">Je hebt nog geen lessen gevolgd.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Cancel modal functions
    function openCancelModal(lessonId) {
        document.getElementById('cancel-modal-' + lessonId).style.display = 'flex';
    }
    
    function closeCancelModal(lessonId) {
        document.getElementById('cancel-modal-' + lessonId).style.display = 'none';
    }
    
    function toggleCustomReason(lessonId) {
        const customReasonDiv = document.getElementById('custom-reason-' + lessonId);
        const reasonOptions = document.getElementsByName('reason-option-' + lessonId);
        
        // Check if "Other" is selected
        if (reasonOptions[2].checked) {
            customReasonDiv.style.display = 'block';
            document.getElementById('submit-btn-' + lessonId).disabled = true;
            document.getElementById('submit-btn-' + lessonId).classList.add('opacity-50', 'cursor-not-allowed');
            
            // Add event listener to textarea
            document.getElementById('custom-reason-text-' + lessonId).addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    document.getElementById('submit-btn-' + lessonId).disabled = false;
                    document.getElementById('submit-btn-' + lessonId).classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    document.getElementById('submit-btn-' + lessonId).disabled = true;
                    document.getElementById('submit-btn-' + lessonId).classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        } else {
            customReasonDiv.style.display = 'none';
        }
    }
    
    function updateReason(lessonId, value) {
        document.getElementById('reason-input-' + lessonId).value = value;
        document.getElementById('submit-btn-' + lessonId).disabled = false;
        document.getElementById('submit-btn-' + lessonId).classList.remove('opacity-50', 'cursor-not-allowed');
    }
    
    function submitCancelForm(lessonId) {
        const reasonInput = document.getElementById('reason-input-' + lessonId);
        const reasonOptions = document.getElementsByName('reason-option-' + lessonId);
        
        // If "Other" is selected, use the custom text
        if (reasonOptions[2].checked) {
            reasonInput.value = document.getElementById('custom-reason-text-' + lessonId).value;
        }
        
        // Submit the form
        document.getElementById('cancel-form-' + lessonId).submit();
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('[id^="cancel-modal-"]');
        modals.forEach(function(modal) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>