<x-guest-layout
    pageTitle='Multi-Factor Setup | Clementine Solutions'
    pageDescription=''
    pageKeywords=''
    pageImage='logo.png'
    pageImageAlt='Clementine Solutions logo'
    pageType='website'
    pageUrl='{{ url()->full() }}'
    pageHeading='Authenticator Setup'
>
    @if ($method === 'totp')
        {{-- View container --}}
        <div class="max-w-md mx-auto bg-white shadow-md rounded-md p-6">
            {{-- QR Code --}}
            <div class="flex justify-center mb-6">
                {!! $qrCode !!}
            </div>

            <p class="text-gray-600 text-base mb-6 text-center">
                Scan this QR code with your authenticator app, then enter the 6-digit code below.
            </p>


            {{-- Form fields --}}
            <form
                method="POST"
                action="/multi-factor/verify/totp"
                class="space-y-4"
            >
                {{-- CSRF tokens --}}
                @csrf

                <div class="relative w-full">
                    <x-labeled-input
                        inputId="Verification Code"
                        id="totp_code"
                        name="totp_code"
                        type="text"
                        required
                    >
                        Verification Code
                    </x-labeled-input>

                    @error('totp_code')
                        <div>{{ $message }}</div>
                    @enderror
                </div>


                {{-- Buttons --}}
                <x-button
                    type="submit"
                    variant="info"
                >
                    Verify
                </x-button>
            </form>
        </div>
    @endif
</x-guest-layout>
