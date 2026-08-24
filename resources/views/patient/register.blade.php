<x-guest-layout>
    <h2 class="text-lg font-medium text-gray-900 mb-4">
        {{ __('Patient Registration') }}
    </h2>

    @if (session('success'))
        <x-alert type="success" :title="session('success')" class="mb-4" />
    @endif

    @if (session('error'))
        <x-alert type="error" :title="session('error')" class="mb-4" />
    @endif

    <form method="POST" action="{{ route('patient.send-otp') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus placeholder="+20 1XX XXX XXXX" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send OTP') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">
            Already have an account? <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900">Login</a>
        </p>
    </div>
</x-guest-layout>
