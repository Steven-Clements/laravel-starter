<x-guest-layout
    pageTitle='Sign Up | Clementine Solutions'
    pageDescription=''
    pageKeywords=''
    pageImage='logo.png'
    pageImageAlt='Clementine Solutions logo'
    pageType='website'
    pageUrl='{{ url()->full() }}'
    pageHeading='Sign Up'
>
    <main class="flex items-center justify-center bg-gray-100">
        <form
            method="POST"
            action="/users"
            class="bg-white shadow-md rounded-md p-8 w-full max-w-2xl"
        >
            @csrf

            <div class="flex items-center justify-center gap-10 mb-8">
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                    <span class="text-gray-500 text-sm">Upload</span>
                </div>

                <input type="file" name="profile_picture" class="mt-2 text-sm" />

                @error('profile_picture')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 my-6">
            
                <div class="relative w-full">
                    <x-labeled-input
                        inputId="Name"
                        name="name"
                        type="text"
                        required
                    >
                        Name
                    </x-labeled-input>

                    @error('name')
                        <div>{{ $message }}</div>
                    @enderror
                </div>

                <div class="relative w-full">
                    <x-labeled-input
                        inputId="Username"
                        name="username"
                        type="text"
                    >
                        Username
                    </x-labeled-input>

                    @error('username')
                        <div>{{ $message }}</div>
                    @enderror
                </div>

                <div class="relative w-full">
                    <x-labeled-input
                        inputId="Email"
                        name="email"
                        type="email"
                        required
                    >
                        Email
                    </x-labeled-input>

                    @error('email')
                        <div>{{ $message }}</div>
                    @enderror
                </div>

                <div class="relative w-full">
                    <x-labeled-input
                        inputId="Password"
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

                <div class="relative w-full md:col-span-2">
                    <x-labeled-input
                        inputId="Confirm Password"
                        name="password_confirmation"
                        type="password"
                        required
                    >
                        Confirm Password
                    </x-labeled-input>

                    @error('password_confirmation')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <x-button 
                type="submit"
            >
                <i class="fas fa-pen mr-1"></i> Register
            </x-button>

            <p class="mt-6 text-center text-sm">
                Already have an account?
                <a href="/login" class="text-orange-500 font-bold hover:text-orange-600">Sign In</a>
            </p>
        </form>
    </main>
</x-guest-layout>
