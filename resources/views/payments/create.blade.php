<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Betaling voltooien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold mb-6 text-[#1B4965]">Betaal je boeking</h3>
                    
                    @if(session('booking_message'))
                        <div class="mb-5 p-4 bg-green-100 text-green-800 rounded border-l-4 border-green-500">
                            {{ session('booking_message') }}
                        </div>
                    @endif
                    
                    <div class="mb-8 p-4 bg-[#FFFCEA] rounded-xl">
                        <h4 class="text-xl font-medium mb-2">Boeking details:</h4>
                        <ul class="mb-2">
                            <li><span class="font-medium">Datum:</span> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</li>
                            <li><span class="font-medium">Tijd:</span> {{ $booking->booking_time === 'morning' ? 'Ochtend (9:00-12:30)' : 'Middag (13:00-16:30)' }}</li>
                            <li><span class="font-medium">Deelnemers:</span> {{ $booking->participants }}</li>
                            <li><span class="font-medium">Te betalen bedrag:</span> €{{ number_format($amount, 2, ',', '.') }}</li>
                        </ul>
                    </div>

                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        
                        <div class="mb-4">
                            <x-input-label for="payment_method" :value="__('Betaalmethode')" />
                            <select id="payment_method" name="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="ideal" {{ old('payment_method') == 'ideal' ? 'selected' : '' }}>iDEAL</option>
                                <option value="creditcard" {{ old('payment_method') == 'creditcard' ? 'selected' : '' }}>Credit Card</option>
                                <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox" name="agree_terms" value="1">
                                <span class="ml-2">Ik ga akkoord met de <a href="#" class="text-blue-600 hover:underline">algemene voorwaarden</a> en het <a href="#" class="text-blue-600 hover:underline">privacybeleid</a>.</span>
                            </label>
                            <x-input-error :messages="$errors->get('agree_terms')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Later betalen
                            </a>
                            <x-primary-button>
                                {{ __('Nu betalen') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
