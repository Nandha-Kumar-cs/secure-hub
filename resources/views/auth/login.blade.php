<x-guest-layout>
    <!-- re-captcha v3 -->
    <script
        src="https://www.google.com/recaptcha/api.js?render={{ config('services.re-captcha-v3.site_key') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- hiddent input field  -->
        <input type="hidden" name="re-captcha-v3" id="re-captcha-v3">

        <!-- type of the re-captcha  -->
        <input type="hidden" name="type" value="3">
        
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- captcha error -->
        <x-input-error :messages="$errors->get('captcha')" class="mt-2" />

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    <!-- re-captcha version 2 -->
    <div class="g-recaptcha transform scale-75 align-self-center {{ $errors->get('re-captcha-2') ? 'block' : 'hidden' }} " data-sitekey="{{ config('services.re-captcha-v2.site_key') }}"></div>

    @push('scripts')
        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config('services.re-captcha-v3.site_key') }}', { action: 'submit' }).then(function (token) {
                    document.getElementById('re-captcha-v3').value = token;
                });
            });
        </script>
    @endpush
</x-guest-layout>