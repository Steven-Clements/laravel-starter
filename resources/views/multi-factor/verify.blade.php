<x-guest-layout
    pageTitle='Verify your Identity | Clementine Solutions'
    pageDescription=''
    pageKeywords=''
    pageImage='logo.png'
    pageImageAlt='Clementine Solutions logo'
    pageType='website'
    pageUrl='{{ url()->full() }}'
    pageHeading='Multi-Factor Verification'
>
    <div class="max-w-md mx-auto px-6 py-10">
        <!-- Card -->
        <div class="bg-white shadow-md rounded-md p-6">
            <!-- Header -->
            <div class="flex items-center space-x-3 mb-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-sms text-blue-500"></i>
                </div>
                <h2 class="text-lg font-semibold">Enter Verification Code</h2>
            </div>

            <!-- Instructions -->
            <p class="text-gray-600 text-sm mb-6">
                We sent a 6-digit verification code to your phone. Enter it below to continue.
            </p>

            <!-- Form -->
            <form method="POST" action="/multi-factor/verify/sms" class="space-y-6">
                @csrf

                <!-- Code Input -->
                <div class="relative w-full">
                    <input type="text" name="verification_code" required maxlength="6"
                        class="peer w-full border-b-2 border-gray-300 bg-transparent py-2 text-center tracking-widest text-lg focus:outline-none focus:border-blue-400"
                        placeholder="123456" />
                    <label class="absolute left-0 top-2 text-gray-500 transition-all 
                        peer-focus:text-blue-400 peer-focus:-translate-y-5 
                        peer-valid:text-blue-400 peer-valid:-translate-y-5">
                        Verification Code
                    </label>
                </div>

                <!-- Submit -->
                <x-button variant="info" type="submit" class="w-full">
                    Verify Code
                </x-button>
            </form>

            <!-- Resend Option -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Didn't receive the code?
                <a href="" class="text-blue-500 underline">
                    Resend SMS
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
