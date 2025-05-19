<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alle lessen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Overzicht van al je lessen</h3>
                @if($lessons->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="py-2 px-4">Datum</th>
                                <th class="py-2 px-4">Tijd</th>
                                <th class="py-2 px-4">Status</th>
                                <th class="py-2 px-4">
                                    @if($isStudent)
                                    Instructeur
                                    @else
                                    Student
                                    @endif
                                </th>
                                <th class="py-2 px-4">Opmerking</th>
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
                                    {{ $lesson->lesson_status }}
                                </td>
                                <td class="py-2 px-4">
                                    @if($isStudent)
                                    {{-- Show instructor name --}}
                                    {{ $lesson->instructor->user->name ?? '-' }}
                                    @else
                                    {{-- Show student name --}}
                                    {{ $lesson->registration->student->user->name ?? '-' }}
                                    @endif
                                </td>
                                <td class="py-2 px-4">
                                    {{ $lesson->remark ?? '-' }}
                                </td>
                                <td class="py-2 px-4">
                                    @if($lesson->lesson_status !== 'Canceled')
                                    <button
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-sm"
                                        x-data x-on:click.prevent="$dispatch('open-cancel-modal-{{ $lesson->id }}')">
                                        Annuleer
                                    </button>
                                    @else
                                    <span
                                        class="inline-block px-3 py-1 rounded bg-gray-300 text-gray-600 text-sm cursor-not-allowed">Geannuleerd</span>
                                    @endif

                                    <!-- Cancel Modal -->
                                    <div x-data="{ open: false }" x-on:open-cancel-modal-{{ $lesson->id }}.window="open
                                        = true"
                                        x-show="open"
                                        style="display: none;"
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black
                                        bg-opacity-40"
                                        >
                                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                                            <h2 class="text-xl font-bold mb-4">Les annuleren</h2>
                                            <form method="POST" action="{{ route('lessons.cancel', $lesson->id) }}">
                                                @csrf
                                                <label class="block mb-2 font-semibold">Reden voor annulering:</label>
                                                <textarea name="reason" required
                                                    class="w-full border rounded p-2 mb-4"></textarea>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" class="px-4 py-2 rounded bg-gray-200"
                                                        x-on:click="open = false">Sluiten</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">Annuleer
                                                        les</button>
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
                @else
                <p class="text-gray-500">Je hebt nog geen lessen gevolgd.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>