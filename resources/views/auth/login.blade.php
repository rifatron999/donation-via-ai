<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form id="login-form" method="POST" action="{{ route('donor.login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email"
                         name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password"
                         name="password" required autocomplete="current-password" />
            </div>

            <!-- Login As Dropdown -->
            <div class="mt-4">
                <x-label for="user_type" value="{{ __('Login as') }}" />
                <select id="user_type" name="user_type" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="donor">Donor</option>
                    <option value="vendor">Vendor</option>
                </select>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <!-- JavaScript to dynamically change form action -->
        <script>
            document.getElementById('user_type').addEventListener('change', function () {
                const form = document.getElementById('login-form');
                const selected = this.value;

                if (selected === 'vendor') {
                    form.action = "{{ route('vendor.login') }}";
                } else {
                    form.action = "{{ route('donor.login') }}";
                }
            });
        </script>

    </x-authentication-card>
</x-guest-layout>
