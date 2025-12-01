<!DOCTYPE html>

<html lang="en" class="h-full bg-gray-100">
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
        <meta property="og:image" content="{{ asset($pageImage) }}" />
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

    
    {{-- Visual elements --}}
    <body class="h-full">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-gray-100">
            <div class="hidden md:flex md:flex-shrink-0 bg-gray-900 text-white w-80 flex-col">
                {{-- Site branding --}}
                <a href="/accounts/dashboard">
                    <div class="flex items-center h-16 px-4">
                        <img src="{{ asset('logo.png') }}" alt="Clementine Solutions" class="size-8 mr-2 flex-none" />
                        <div class="flex-1 min-w-0">
                            <span class="text-white font-bold text-lg">Clementine Solutions</span>
                        </div>
                    </div>
                </a>

                <hr class="border-white/10 my-4" />


                {{-- Sidebar menu (desktop) --}}
                <nav class="flex-1 px-4 py-6 space-y-2 text-sm overflow-y-auto">
                    <x-link
                        href="/dashboard"
                        type="main-menu"
                        :active="request()->is('dashboard')"
                    >
                        Dashboard
                    </x-link>
                </nav>


                {{-- Profile info --}}
                <a href="/accounts/profile">
                    <div class="px-4 py-4 border-t border-white/10 flex items-center space-x-3">
                        <img src="{{ asset('default-profile-picture.png') }}" alt="Profile picture" class="size-8 rounded-full outline outline-white/10 flex-none" />
                        <div class="min-w-0">
                            <div class="text-sm font-medium truncate">Steven Clements</div>
                            <div class="text-xs text-gray-400 truncate">clements.steven07@outlook.com</div>
                        </div>
                    </div>
                </a>
            </div>


            {{-- Sidebar menu (mobile) --}}
            <div x-show="sidebarOpen" x-transition class="fixed inset-0 z-40 flex md:hidden">
                <div class="bg-gray-900 text-white w-64 flex flex-col">
                    <div class="flex items-center h-16 px-4">
                        <img src="{{ asset('logo.png') }}" alt="Clementine Solutions logo" class="size-8 mr-2 flex-none" />
                        <div class="flex-1 min-w-0">
                            <span class="text-white font-bold text-lg">Clementine Solutions</span>
                        </div>
                    </div>
                    <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
                        <x-link
                            href="/dashboard"
                            type="main-menu"
                            :active="request()->is('dashboard')"
                        >
                            Dashboard
                        </x-link>
                    </nav>
                </div>
                <div @click="sidebarOpen = false" class="flex-shrink-0 w-full bg-black bg-opacity-50"></div>
            </div>


            {{-- User menu --}}
            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between bg-white shadow px-4 py-3 md:px-6">
                    <div class="flex items-center space-x-2">
                        <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-900">{{ $pageHeading ?? 'Dashboard' }}</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center focus:outline-none">
                                <img src="{{ asset('default-profile-picture.png') }}" alt="Profile picture" class="size-8 rounded-full outline outline-gray-300" />
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black/5 z-20">
                                <x-link
                                    href="/users/profile"
                                    type="sub-menu"
                                >
                                    My Profile
                                </x-link>
                                
                                <x-link
                                    href="/accounts/settings"
                                    type="sub-menu"
                                >
                                    Settings
                                </x-link>
                                
                                <x-link
                                    href="/sessions/destroy"
                                    type="sub-menu"
                                >
                                    Sign Out
                                </x-link>
                            </div>
                        </div>
                    </div>
                </header>


                {{-- Slotted content --}}
                <main class="flex-1 overflow-y-auto px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>


                {{-- Auth footer --}}
                <footer class="mt-12 bg-gray-900 text-white px-6 py-5 text-sm">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-6 sm:space-y-0">
                        <div class="flex flex-wrap justify-center sm:justify-start gap-x-6 gap-y-2 text-white/80">
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

                        <div class="flex items-center space-x-4 text-white/60">
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
                            <span class="hidden sm:inline">© 2025 Clementine Technology Solutions LLC.</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>