<x-guest-layout>
    <h2 class="text-lg font-medium text-gray-900 mb-4">
        {{ __('Verify OTP') }}
    </h2>

    @if (session('success'))
        <x-alert type="success" :title="session('success')" class="mb-4" />
    @endif

    @if (session('error'))
        <x-alert type="error" :title="session('error')" class="mb-4" />
    @endif

    <form method="POST" action="{{ route('patient.verify-otp.submit') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="otp" :value="__('Enter OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" :value="old('otp')" required autofocus maxlength="6" placeholder="123456" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
