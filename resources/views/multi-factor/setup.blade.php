<x-guest-layout
    pageTitle='Multi-Factor Setup | Clementine Solutions'
    pageDescription=''
    pageKeywords=''
    pageImage='logo.png'
    pageImageAlt='Clementine Solutions logo'
    pageType='website'
    pageUrl='{{ url()->full() }}'
    pageHeading='Multi-Factor Setup'
>
    @if ($method === 'sms-voice') {
        {{-- View container --}}
        <div class="max-w-md mx-auto px-6 py-10">
            <div class="bg-white shadow-md rounded-md p-6">
                <p class="text-gray-600 text-sm mb-6">
                    Enter your phone number to receive a verification code via SMS.
                </p>


                {{-- Form fields --}}
                <form method="POST" action="/multi-factor/send-sms" class="space-y-6">
                    {{-- CSRF token --}}
                    @csrf

                    <div class="relative w-full">
                        <input type="tel" name="phone" required
                            class="peer w-full border-b-2 border-gray-300 bg-transparent py-2 text-center focus:outline-none focus:border-blue-400" />
                        <label class="absolute left-0 top-2 text-gray-500 transition-all 
                            peer-focus:text-blue-400 peer-focus:-translate-y-5 
                            peer-valid:text-blue-400 peer-valid:-translate-y-5">
                            Phone Number
                        </label>
                    </div>


                    <!-- Buttons -->
                    <x-button variant="info" type="submit" class="w-full">
                        Send Verification Code
                    </x-button>
                </form>
            </div>
        </div>
    }
    @elseif ($method === 'totp')
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
