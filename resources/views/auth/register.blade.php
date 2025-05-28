<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="text-xl font-bold mb-4">Account aanmaken</h2>
        <p class="mb-4 text-sm text-gray-600">Vul je e-mailadres in om te beginnen met registreren. Je ontvangt een activatielink om je account te activeren en je gegevens in te vullen.</p>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
