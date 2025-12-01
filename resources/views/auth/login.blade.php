<x-guest-layout
    pageTitle='Sign In | Clementine Solutions'
    pageDescription=''
    pageKeywords=''
    pageImage='logo.png'
    pageImageAlt='Clementine Solutions logo'
    pageType='website'
    pageUrl='{{ url()->full() }}'
    pageHeading='Sign In'
>
    {{-- View container --}}
    <main class="flex items-center justify-center mb-20">
        {{-- Login form --}}
        <div class="w-full max-w-[300px] my-10">
            <form
                method="POST"
                action="/auth/login"
                class="flex flex-col items-center"
            >
            {{-- CSRF token --}}
            @csrf
            

            {{-- Form fields --}}
            <div class="relative w-[300px] mb-6">
                <x-labeled-input
                    inputId="Email"
                    id="emailOrUsername"
                    name="emailOrUsername"
                    type="email"
                    required
                >
                    Email or Username
                </x-labeled-input>

                @error('emailOrUsername')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="relative w-[300px] mb-6">
                <x-labeled-input
                    inputId="Password"
                    id="password"
                    name="password"
                    type="password"
                    required
                >
                    Password
                </x-labeled-input>

                @error('password')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="relative w-[300px] mb-6 flex justify-center">
                <input type="checkbox" id="remember" name="remember" class="block mr-2" />
                <label for="remember">
                    Remember This Device?
                </label>
            </div>


            {{-- Buttons and links --}}
            <x-button type="submit">
                <i class="fas fa-lock mr-1"></i> Login
            </x-button>
            <x-button
                variant="alternate"
                :isLink="true"
            >
                <i class="fas fa-circle-question mr-1"></i> Account Help
            </x-button>

            <p class="mt-6 text-center text-sm">
                Don't have an account?
                <a href="/register" class="text-orange-500 font-bold hover:text-orange-600">Sign Up</a>
            </p>
            </form>
        </div>
    </main>
</x-guest-layout>
