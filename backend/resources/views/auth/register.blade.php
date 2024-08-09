<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Imię') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-label for="surname" value="{{ __('Nazwisko') }}" />
                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autofocus autocomplete="surname" />
            </div>

            <div>
                <x-label for="weight" value="{{ __('Waga (kg)') }}" />
                <x-input id="weight" class="block mt-1 w-full" type="number" name="weight" :value="old('weight')" required autofocus autocomplete="weight" />
            </div>

            <div>
                <x-label for="height" value="{{ __('Wzrost (cm)') }}" />
                <x-input id="height" class="block mt-1 w-full" type="number" name="height" :value="old('height')" required autofocus autocomplete="height" />
            </div>

            <div>
                <x-label for="age" value="{{ __('Wiek (lata)') }}" />
                <x-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" required autofocus autocomplete="age" />
            </div>

            <div>
                <x-label for="training_intership" value="{{ __('Staż treningowy (lata)') }}" />
                <x-input id="training_intership" class="block mt-1 w-full" type="number" name="training_intership" :value="old('training_intership')" required autofocus autocomplete="training_intership" />
            </div>

            <div>
                <x-label for="desc" value="{{ __('Opis profilu') }}" />
                <x-input id="desc" class="block mt-1 w-full" type="text" name="desc" :value="old('desc')" required autofocus autocomplete="desc" />
            </div>

            <div>
                <x-label for="role_id" value="{{ __('Rola') }}" />
                <select id="role_id" name="role_id" class="block mt-1 w-full" required autofocus autocomplete="role_id">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Hasło') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Potwierdź hasło') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Już jesteś zarejestrowany?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Zarejestruj') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>