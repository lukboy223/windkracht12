<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h1 class="text-xl font-bold text-gray-800">Instructeur Details</h1>
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Terug
                    </a>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h2 class="text-lg font-medium mb-2">Persoonlijke Informatie</h2>
                            <div class="bg-gray-50 rounded-md p-4">
                                <div class="mb-2">
                                    <span class="font-medium">Naam:</span> {{ $instructor->user->name }}
                                </div>
                                <div class="mb-2">
                                    <span class="font-medium">Email:</span> {{ $instructor->user->email }}
                                </div>
                                <div class="mb-2">
                                    <span class="font-medium">Instructeur nummer:</span> {{ $instructor->number ?? 'Niet beschikbaar' }}
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-lg font-medium mb-2">Aanstaande Lessen</h2>
                            <div class="bg-gray-50 rounded-md p-4">
                                @php
                                    $upcomingLessons = \App\Models\Lesson::where('instructor_id', $instructor->id)
                                        ->where('lesson_status', 'Planned')
                                        ->where('start_date', '>=', today())
                                        ->orderBy('start_date')
                                        ->orderBy('start_time')
                                        ->take(3)
                                        ->get();
                                @endphp
                                
                                @if($upcomingLessons->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($upcomingLessons as $lesson)
                                            <li>
                                                <div class="text-sm">
                                                    <strong>{{ \Carbon\Carbon::parse($lesson->start_date)->format('d-m-Y') }}</strong> om 
                                                    {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }}
                                                </div>
                                                <div class="text-xs text-gray-600">
                                                    Locatie: {{ $lesson->location ?? '-' }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 text-sm italic">Geen geplande lessen</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
