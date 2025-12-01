<x-guest-layout
    pageTitle='Registration Successful | Clementine Solutions'
    pageDescription=''
    pageKeywords=''
    pageImage='logo.png'
    pageImageAlt='Clementine Solutions logo'
    pageType='website'
    pageUrl='{{ url()->full() }}'
    pageHeading='Registration Successful'
>
    {{-- View container --}}
    <main class="bg-gray-100">
        {{-- Registration success card --}}
        <div class="bg-white shadow-md rounded-md p-6 max-w-md mx-auto mb-16">
            <x-notification-card
                heading="Registration Successful"
            >
                <p class="text-gray-600 text-sm">
                    Your account has been created. Please verify your email address before logging in.
                </p>
            </x-notification-card>
        </div>


        {{-- Request verification card --}}
        <div class="bg-white shadow-md rounded-md p-6 max-w-md mx-auto mb-16">
            <x-notification-card
                heading="Resend Verification Code"
                variant="retry"
            >
                <p class="mb-10">Didn't receive a code?</p>

                {{-- Request verification email --}}
                <form
                    method="POST"
                    action="resend-verification"
                    class="space-y-4"
                >
                    {{-- CSRF token --}}
                    @csrf

                    <div class="relative w-full">
                        <x-labeled-input
                            inputId="Email"
                            type="email"
                            name="email"
                            required
                        >
                            Email
                        </x-labeled-input>
                    </div>

                    {{-- Buttons --}}
                    <x-button type="submit">
                        Send New Code
                    </x-button>
                </form>
            </x-notification-card>  
        </div>
    </main>
</x-guest-layout>
