<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (session('success'))
    <div class="mb-4 px-6 py-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 px-6 py-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded shadow">
        <strong>Er is iets misgegaan:</strong>
        <ul class="list-disc pl-5 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($lessons !== 'admin')
                    <h3 class="mt-6 mb-2 text-lg font-bold">Jouw lessen deze week</h3>
                    @if(isset($lessons) && $lessons->count())
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($lessons as $lesson)
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow flex flex-col relative">
                            <div>
                                <div class="font-semibold text-lg text-[#1B4965]">
                                    {{ \Carbon\Carbon::parse($lesson->start_date)->format('d-m-Y') }}
                                    {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    Status: <span class="font-medium">{{ $lesson->lesson_status }}</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                @if($lesson->lesson_status !== 'Canceled')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow" x-data
                                    x-on:click.prevent="$dispatch('open-cancel-modal-{{ $lesson->id }}')">
                                    Annuleer
                                </button>
                                @else
                                <span
                                    class="inline-block px-4 py-2 rounded bg-gray-300 text-gray-600 cursor-not-allowed">Geannuleerd</span>
                                @endif
                            </div>
                            <!-- Cancel Modal -->
                            <div x-data="{ open: false }" x-on:open-cancel-modal-{{ $lesson->id }}.window="open = true"
                                x-show="open"
                                style="display: none;"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
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
                        </div>
                        @endforeach
                    </div>

                    @else
                    <p class="text-gray-500">Je hebt deze week geen lessen gepland.</p>
                    @endif
                    @endif
                    <h3 class="mt-10 mb-2 text-lg font-bold">Jouw notificaties</h3>
                    @if(isset($notifications) && $notifications->count())
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($notifications as $notification)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 shadow flex flex-col">
                            <div class="font-semibold text-[#b08900] mb-1">
                                {{ \Carbon\Carbon::parse($notification->date)->format('d-m-Y H:i') }}
                            </div>
                            <div class="text-sm text-gray-700 mb-2">
                                <span class="font-bold">{{ $notification->type }}</span>
                            </div>
                            <div class="text-gray-800 mb-2">
                                {!! $notification->message !!}
                            </div>
                            @if(!empty($notification->link))
                            <a href="{{ $notification->link }}"
                                class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition underline"
                                target="_blank">
                                Naar actie
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500">Je hebt geen notificaties.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>