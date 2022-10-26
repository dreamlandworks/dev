<style>
.min-h-screen.flex.flex-col.sm\:justify-center.items-center.pt-6.sm\:pt-0.bg-gray-100 {
    background: #1d4962;
    height: 600px;
}
.w-full.sm\:max-w-md.mt-6.px-6.py-4.bg-white.shadow-md.overflow-hidden.sm\:rounded-lg {
    height: 400px;
    width: 400px;
    padding-top: 80px;
    /* padding: 50px; */
    padding-left: 40px;
    padding-right: 40px;
}
.font-sans.text-gray-900.antialiased {
    background: #517faf;
    height:600px;
}

form.km_form {
    font-size: .9rem;
    width: 79%;
    height: 46%;
    display: block;
    padding: 87px 30px;
    margin: 60px 0;
    background: #fff;
    border-radius: 5px;
    position: relative;
    left: 98%;
    /* top: 32px; */

}
</style>

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            {{-- <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a> --}}
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="km_form mx-auto">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('User Name')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
