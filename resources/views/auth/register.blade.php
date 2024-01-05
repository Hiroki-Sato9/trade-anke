<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="user[name]" :value="old('user.name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('user.name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="user[email]" :value="old('user.email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('user.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex flex-row">
                <x-input-label for="password" :value="__('Password')" />
                <span class="text-sm">（8文字以上）</span>
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="user[password]"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('user.password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="user[password_confirmation]" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('user.password_confirmation')" class="mt-2" />
        </div>
        
        
        <!-- gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />

            <select class="" id="gender_id" name="profile[gender_id]">
                @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('profile.gender')" class="mt-2" />
        </div>
        
        <!-- age -->
        <div class="mt-4">
            <x-input-label for="age" :value="__('Age')" />

            <x-text-input id="age" class="block mt-1 w-full"
                            type="number"
                            name="profile[age]" :value="old('profile.age')" required autocomplete="age" />

            <x-input-error :messages="$errors->get('profile.age')" class="mt-2" />
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
