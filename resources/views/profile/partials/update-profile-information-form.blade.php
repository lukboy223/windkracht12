<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and contact details.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <h3 class="text-md font-medium text-gray-700 border-b pb-2">Personal Information</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <!-- First Name -->
            <div>
                <x-input-label for="firstname" :value="__('First Name')" />
                <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full" :value="old('firstname', $user->firstname)" required autofocus autocomplete="firstname" />
                <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
            </div>

            <!-- Infix -->
            <div>
                <x-input-label for="infix" :value="__('Infix')" />
                <x-text-input id="infix" name="infix" type="text" class="mt-1 block w-full" :value="old('infix', $user->infix)" autocomplete="infix" />
                <x-input-error class="mt-2" :messages="$errors->get('infix')" />
            </div>
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="lastname" :value="__('Last Name')" />
            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user->lastname)" required autocomplete="lastname" />
            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Birthdate -->
        <div>
            <x-input-label for="birthdate" :value="__('Birthdate')" />
            <x-text-input id="birthdate" name="birthdate" type="date" class="mt-1 block w-full" :value="old('birthdate', $user->birthdate ? date('Y-m-d', strtotime($user->birthdate)) : '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
        </div>

        <h3 class="text-md font-medium text-gray-700 border-b pb-2 pt-4">Contact Information</h3>

        <!-- Street Name -->
        <div>
            <x-input-label for="street_name" :value="__('Street Name')" />
            <x-text-input id="street_name" name="street_name" type="text" class="mt-1 block w-full" :value="old('street_name', $user->contact->street_name ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('street_name')" />
        </div>

        <!-- House Number and Addition -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="house_number" :value="__('House Number')" />
                <x-text-input id="house_number" name="house_number" type="text" class="mt-1 block w-full" :value="old('house_number', $user->contact->house_number ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('house_number')" />
            </div>
            <div>
                <x-input-label for="addition" :value="__('Addition')" />
                <x-text-input id="addition" name="addition" type="text" class="mt-1 block w-full" :value="old('addition', $user->contact->addition ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('addition')" />
            </div>
        </div>

        <!-- Postal Code and Place -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="postal_code" :value="__('Postal Code')" />
                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $user->contact->postal_code ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
            </div>
            <div>
                <x-input-label for="place" :value="__('City')" />
                <x-text-input id="place" name="place" type="text" class="mt-1 block w-full" :value="old('place', $user->contact->place ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('place')" />
            </div>
        </div>

        <!-- Mobile -->
        <div>
            <x-input-label for="mobile" :value="__('Mobile Number')" />
            <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full" :value="old('mobile', $user->contact->mobile ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('mobile')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
