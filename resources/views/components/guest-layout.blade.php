<!DOCTYPE html>

<html class="h-full bg-gray-100">
    {{-- Non-visual elements --}}
    <head>
        {{-- Viewport and character encoding --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        {{-- Site-wide metadata --}}
        <meta property="og:site_name" content="Laravel starter" />
        <meta name="twitter:card" content="summary_large_image" />


        {{-- View-specific metadata --}}
        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $pageDescription }}" />
        <meta name="keywords" content="{{ $pageKeywords }}" />


        {{-- Social media integration --}}
        <meta property="og:type" content="{{ $pageType }}" />
        <meta property="og:title" content="{{ $pageTitle }}" />
        <meta property="og:description" content="{{ $pageDescription }}" />
        <meta property="og:image" content="{{ $pageImage }}" />
        <meta name="twitter:image:alt" content="{{ $pageImageAlt }}" />
        <meta property="og:url" content="{{ $pageUrl }}" />


        {{-- Social media analytics --}}
        <meta property="fb:app_id" content="" />
        <meta name="twitter:site" content="">


        {{-- External libraries --}}
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            integrity="sha512-..."
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/alpinejs" defer></script>


        {{-- Asset links --}}
        <link rel="icon" href="{{ asset('favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('app.css') }}" />
    </head>

    
    <body class="h-full">
        <div class="min-h-full">
            <nav x-data="{ mobileOpen: false }" class="bg-gray-900">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex items-center">
                            <a href="/">
                                <div class="shrink-0 flex items-center">
                                    <img src="{{ asset('logo.png') }}" alt="Clementine Solutions logo" class="size-10" />
                                    <h1 class="ml-1 text-white font-bold text-lg">Clementine Solutions</h1>
                                </div>
                            </a>

                            <div class="hidden md:block ml-10">
                                <div class="flex items-baseline space-x-4">
                                    <x-link
                                        href="/products"
                                        type="main-menu"
                                        :active="request()->is('products')"
                                    >
                                        Products
                                    </x-link>
                                    <x-link
                                        href="/services"
                                        type="main-menu"
                                        :active="request()->is('services')"
                                    >
                                        Services
                                    </x-link>
                                    <x-link
                                        href="/guides"
                                        type="main-menu"
                                        :active="request()->is('guides')"
                                    >
                                        Guides
                                    </x-link>
                                    <x-link
                                        href="/blog"
                                        type="main-menu"
                                        :active="request()->is('blog')"
                                    >
                                        Blog
                                    </x-link>
                                    <x-link
                                        href="/contact"
                                        type="main-menu"
                                        :active="request()->is('contact')"
                                    >
                                        Contact
                                    </x-link>
                                </div>
                            </div>
                        </div>
                        

                        <div class="hidden md:flex items-center space-x-4">
                            <button type="button" class="rounded-full p-1 text-gray-400 hover:text-white focus:outline-none">
                                <span class="sr-only">View notifications</span>
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>

                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center rounded-full focus:outline-none">
                                    <span class="sr-only">Open user menu</span>
                                    <img src="{{ asset('default-profile-picture.png') }}" alt="Profile" class="size-8 rounded-full outline outline-white/10" />
                                </button>
                                <div x-show="open" x-transition @click.outside="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black/5 z-20">
                                    @guest
                                        <x-link
                                            href="/register"
                                            type="sub-menu"
                                            :active="request()->is('register')"
                                        >
                                            Register
                                        </x-link>
                                        <x-link
                                            href="/login"
                                            type="sub-menu"
                                            :active="request()->is('login')"
                                        >
                                            Login
                                        </x-link>
                                    @endguest
                                    @auth
                                        <x-link
                                            href="/users/profile"
                                            type="main-menu"
                                            :active="request()->is('users/profile')"
                                        >
                                            My Profile
                                        </x-link>
                                        <x-link
                                            href="/accounts/settings"
                                            type="main-menu"
                                            :active="request()->is('accounts/settings')"
                                        >
                                            Settings
                                        </x-link>
                                        <x-link
                                            href="/sessions/destroy"
                                            type="main-menu"
                                        >
                                            Sign Out
                                        </x-link>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <div class="md:hidden">
                            <button @click="mobileOpen = !mobileOpen"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:text-white hover:bg-white/5 focus:outline-none"
                                    :aria-expanded="mobileOpen.toString()">
                                <span class="sr-only">Open main menu</span>
                                <svg x-show="!mobileOpen" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg x-show="mobileOpen" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div x-show="mobileOpen" x-transition
                    class="md:hidden bg-gray-800 text-white px-4 pt-4 pb-6 space-y-4">
                    <nav class="space-y-1">
                        <x-link
                            href="/products"
                            type="main-menu"
                            :active="request()->is('products')"
                        >
                            Products
                        </x-link>
                        <x-link
                            href="/services"
                            type="main-menu"
                            :active="request()->is('services')"
                        >
                            Services
                        </x-link>
                        <x-link
                            href="/guides"
                            type="main-menu"
                            :active="request()->is('guides')"
                        >
                            Guides
                        </x-link>
                        <x-link
                            href="/blog"
                            type="main-menu"
                            :active="request()->is('blog')"
                        >
                            Blog
                        </x-link>
                        <x-link
                            href="/contact"
                            type="main-menu"
                            :active="request()->is('contact')"
                        >
                            Contact
                        </x-link>
                    </nav>

                    <hr class="border-white/10" />

                    @guest
                        <div class="space-y-1 pt-2">
                            <x-link
                                href="/register"
                                type="sub-menu"
                                :active="request()->is('register')"
                            >
                                Register
                            </x-link>
                            <x-link
                                href="/login"
                                type="sub-menu"
                                :active="request()->is('login')"
                            >
                                Login
                            </x-link>
                        </div>
                    @endguest

                    @auth
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('default-profile-picture.png') }}" alt="Profile" class="size-10 rounded-full outline outline-white/10" />
                            <div>
                                <div class="text-base font-medium">Steven Clements</div>
                                <div class="text-sm text-gray-400">clements.steven07@outlook.com</div>
                            </div>
                            <button class="ml-auto text-gray-400 hover:text-white">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-1 pt-2">
                            <x-link
                                href="/users/profile"
                                type="main-menu"
                                :active="request()->is('users/profile')"
                            >
                                My Profile
                            </x-link>
                            <x-link
                                href="/accounts/settings"
                                type="main-menu"
                                :active="request()->is('accounts/settings')"
                            >
                                Settings
                            </x-link>
                            <x-link
                                href="/sessions/destroy"
                                type="main-menu"
                            >
                                Sign Out
                            </x-link>
                        </div>
                    @endauth
                </div>
            </nav>

            <header class="bg-white shadow-sm mt-20">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-center text-gray-700 mt-10">{{ $pageHeading }}</h1>
                </div>
            </header>

            <main>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>

            <footer class="bg-gray-900 text-gray-300">
                <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <div class="md:col-span-2 space-y-4">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('logo.png') }}" alt="Clementine Solutions logo" class="size-10" />
                                <span class="text-white font-bold text-xl">Clementine Solutions</span>
                            </div>
                            <p class="text-sm text-gray-400">
                                Building better solutions for individuals and small businesses.
                            </p>
                            <div class="flex space-x-4 mt-2 text-lg">
                                <x-link
                                    href="https://facebook.com"
                                    type="footer-menu"
                                >
                                    <i class="fab fa-facebook-f"></i>
                                </x-link>
                                <x-link
                                    href="https://instagram.com"
                                    type="footer-menu"
                                >
                                    <i class="fab fa-instagram"></i>
                                </x-link>
                                <x-link
                                    href="https://x.com"
                                    type="footer-menu"
                                >
                                    <i class="fab fa-x"></i>
                                </x-link>
                                <x-link
                                    href="https://github.com"
                                    type="footer-menu"
                                >
                                    <i class="fab fa-github"></i>
                                </x-link>
                                <x-link
                                    href="https://youtube.com"
                                    type="footer-menu"
                                >
                                    <i class="fab fa-youtube"></i>
                                </x-link>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-white tracking-wide uppercase">Products & Services</h3>
                            <ul class="mt-4 space-y-2 text-sm">
                                <x-link
                                    href="/services/development"
                                    type="footer-menu"
                                >
                                    Web & App Development
                                </x-link>
                                <x-link
                                    href="/services/project-management"
                                    type="footer-menu"
                                >
                                    Project Managment
                                </x-link>
                                <x-link
                                    href="/services/technical-writing"
                                    type="footer-menu"
                                >
                                    Docs & Technical Writing
                                </x-link>
                                <hr />
                                <x-link
                                    href="/products/sprout"
                                    type="footer-menu"
                                >
                                    Sprout HRMS
                                </x-link>
                                <x-link
                                    href="/products/greenhouse"
                                    type="footer-menu"
                                >
                                    Greenhouse HMS
                                </x-link>
                                <x-link
                                    href="/products/"
                                    type="footer-menu"
                                >
                                    ReRoot Email Agent
                                </x-link>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-white tracking-wide uppercase">Site Links</h3>
                            <ul class="mt-4 space-y-2 text-sm">
                                <x-link
                                    href="/about"
                                    type="footer-menu"
                                >
                                    About Us
                                </x-link>
                                <x-link
                                    href="/newsletter"
                                    type="footer-menu"
                                >
                                    Newsletter
                                </x-link>
                                <x-link
                                    href="/support"
                                    type="footer-menu"
                                >
                                    Help & Support
                                </x-link>
                                <hr />
                                <x-link
                                    href="/terms"
                                    type="footer-menu"
                                >
                                    Site Terms
                                </x-link>
                                <x-link
                                    href="/privacy"
                                    type="footer-menu"
                                >
                                    Privacy Policy
                                </x-link>
                                <x-link
                                    href="/cookies"
                                    type="footer-menu"
                                >
                                    Cookie Policy
                                </x-link>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-white tracking-wide uppercase">Recent Posts</h3>
                            <ul class="mt-4 space-y-2 text-sm">
                                <x-link
                                    href="/blog/greenhouse-hms"
                                    type="footer-menu"
                                >
                                    Introducing Greenhouse HMS: A Smarter Way to Homeschool
                                </x-link>
                                <x-link
                                    href="/blog/cloud-migration"
                                    type="footer-menu"
                                >
                                    To the Clouds: Is Cloud Migration Right For Me?
                                </x-link>
                                <x-link
                                    href="/blog/email-automation"
                                    type="footer-menu"
                                >
                                    Email Marketing & Verification: Building Trust & Engagment
                                </x-link>
                                <x-link
                                    href="/blog/modern-authentication"
                                    type="footer-menu"
                                >
                                    Modern Authentication: Securing Apps in 2026 and Beyond
                                </x-link>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-12 border-t border-white pt-6 text-sm text-gray-400 text-center">
                        © 2025 Clementine Technology Solutions LLC. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
