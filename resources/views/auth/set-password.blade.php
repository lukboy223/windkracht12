<x-guest-layout>
    <form method="POST" action="{{ route('setPassword.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <h2 class="text-xl font-bold mb-4">Stel je wachtwoord in</h2>

        <div class="mb-4 text-sm text-gray-600">
            <p>Je wachtwoord moet minimaal 12 tekens lang zijn, en moet tenminste één hoofdletter, één getal en één leesteken bevatten.</p>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Set Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
