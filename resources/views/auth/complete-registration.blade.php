<x-guest-layout class="sm:w-1/2">
    <div class="w-full mx-auto">
        <form method="POST" action="{{ route('registration.complete') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <h2 class="text-xl font-bold mb-4">Voltooi je registratie</h2>
            <p class="mb-4 text-sm text-gray-600">Vul je gegevens in om je registratie te voltooien.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold mb-2">Persoonlijke gegevens</h3>
                    
                    <!-- First Name -->
                    <div class="mt-2">
                        <x-input-label for="firstname" :value="__('Voornaam')" />
                        <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="given-name" />
                        <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                    </div>

                    <!-- Infix -->
                    <div class="mt-2">
                        <x-input-label for="infix" :value="__('Tussenvoegsel')" />
                        <x-text-input id="infix" class="block mt-1 w-full" type="text" name="infix" :value="old('infix')" autocomplete="additional-name" />
                        <x-input-error :messages="$errors->get('infix')" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div class="mt-2">
                        <x-input-label for="lastname" :value="__('Achternaam')" />
                        <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autocomplete="family-name" />
                        <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                    </div>

                    <!-- Birthdate -->
                    <div class="mt-2">
                        <x-input-label for="birthdate" :value="__('Geboortedatum')" />
                        <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" required />
                        <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                    </div>
                    
                    <h3 class="font-semibold mt-4 mb-2">Wachtwoord instellen</h3>

                    <!-- Password -->
                    <div class="mt-2">
                        <x-input-label for="password" :value="__('Wachtwoord')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <p class="text-xs text-gray-600 mt-1">
                            Het wachtwoord moet minimaal 12 tekens lang zijn, een hoofdletter, een cijfer en een leesteken bevatten.
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-2">
                        <x-input-label for="password_confirmation" :value="__('Bevestig wachtwoord')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">Contactgegevens</h3>
                    
                    <!-- Street Name -->
                    <div class="mt-2">
                        <x-input-label for="street_name" :value="__('Straatnaam')" />
                        <x-text-input id="street_name" class="block mt-1 w-full" type="text" name="street_name" :value="old('street_name')" />
                        <x-input-error :messages="$errors->get('street_name')" class="mt-2" />
                    </div>

                    <!-- House Number and Addition (side by side) -->
                    <div class="mt-2 flex gap-4">
                        <div class="w-1/2">
                            <x-input-label for="house_number" :value="__('Huisnummer')" />
                            <x-text-input id="house_number" class="block mt-1 w-full" type="text" name="house_number" :value="old('house_number')" />
                            <x-input-error :messages="$errors->get('house_number')" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <x-input-label for="addition" :value="__('Toevoeging')" />
                            <x-text-input id="addition" class="block mt-1 w-full" type="text" name="addition" :value="old('addition')" />
                            <x-input-error :messages="$errors->get('addition')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Postal Code and Place (side by side) -->
                    <div class="mt-2 flex gap-4">
                        <div class="w-1/3">
                            <x-input-label for="postal_code" :value="__('Postcode')" />
                            <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" placeholder="1234 AB" />
                            <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                        </div>
                        <div class="w-2/3">
                            <x-input-label for="place" :value="__('Plaats')" />
                            <x-text-input id="place" class="block mt-1 w-full" type="text" name="place" :value="old('place')" />
                            <x-input-error :messages="$errors->get('place')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Mobile -->
                    <div class="mt-2">
                        <x-input-label for="mobile" :value="__('Telefoonnummer')" />
                        <x-text-input id="mobile" class="block mt-1 w-full" type="tel" name="mobile" :value="old('mobile')" />
                        <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-primary-button>
                    {{ __('Registratie voltooien') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
