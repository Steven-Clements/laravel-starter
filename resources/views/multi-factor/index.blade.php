<x-guest-layout
    pageTitle='Multi-Factor | Clementine Solutions'
    pageDescription=''
    pageKeywords=''
    pageImage='logo.png'
    pageImageAlt='Clementine Solutions logo'
    pageType='website'
    pageUrl='{{ url()->full() }}'
    pageHeading='Secure Your Account'
>
    {{-- View container --}}
    <div class="max-w-5xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-center mb-8">Choose Your Multi-Factor Authentication Method</h1>

        {{-- Flex container --}}
        <div class="flex flex-col md:flex-row gap-6">

            {{-- SMS/voice card --}}
            <div class="bg-white shadow-md rounded-md p-6 flex-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-sms text-blue-500"></i>
                    </div>
                    <h2 class="text-lg font-semibold">SMS / Voice</h2>
                </div>

                <p class="text-gray-600 text-sm">
                    Receive a verification code via text message or phone call.
                </p>

                <x-button
                    href='/multi-factor/setup/sms'
                    :isLink="true"
                    variant="info"
                >
                    Use SMS / Voice
                </x-button>
            </div>

            {{-- Authenticator card --}}
            <div class="bg-white shadow-md rounded-md p-6 flex-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-mobile-alt text-green-500"></i>
                    </div>
                    <h2 class="text-lg font-semibold">Authenticator App</h2>
                </div>

                <p class="text-gray-600 text-sm">
                    Use a time-based one-time password from your authenticator app.
                </p>

                <x-button
                    href='/multi-factor/setup/totp'
                    :isLink="true"
                    variant="success"
                >
                    Use Authenticator
                </x-button>
            </div>

            {{-- Passkey card --}}
            <div class="bg-white shadow-md rounded-md p-6 flex-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-key text-orange-500"></i>
                    </div>

                    <h2 class="text-lg font-semibold">Passkey</h2>
                </div>

                <p class="text-gray-600 text-sm">
                    Securely log in using a passkey stored on your device.
                </p>
                
                <x-button
                    href='/multi-factor/setup/passkey'
                    :isLink="true"
                >
                    Use Passkey
                </x-button>
            </div>
        </div>
    </div>
</x-guest-layout>
