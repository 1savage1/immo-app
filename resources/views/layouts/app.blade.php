<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ImmoPlus - Plateforme Immobilière')</title>

    {{-- Vite (CSS + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js for dropdowns and mobile menu --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex flex-col min-h-screen">

{{-- ================= Navbar ================= --}}
<nav x-data="{ mobileMenuOpen: false }" class="fixed w-full z-50 glass-panel border-b-0 rounded-none bg-black/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-sm">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </span>
                    Immo<span class="text-brand-500">Plus</span>
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-8">
                <div class="flex items-baseline space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                    <a href="{{ route('vente') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Vente</a>
                    <a href="{{ route('location') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Location</a>
                </div>

                <div class="flex items-center gap-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">Connexion</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm py-2 px-4 rounded-lg">S'inscrire</a>
                    @endguest

                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.properties.pending') }}" class="badge-warning px-4 py-2 hover:bg-amber-500/30 transition-colors">Admin Panel</a>
                        @endif

                        <a href="{{ route('properties.create') }}" class="btn-primary text-sm py-2 px-4 rounded-lg flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Ajouter
                        </a>

                        {{-- User Dropdown --}}
                        <div x-data="{ open: false }" class="relative ml-3">
                            <div>
                                <button @click="open = !open" type="button" class="flex items-center gap-2 text-sm text-white focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <div class="w-8 h-8 rounded-full bg-brand-500/20 border border-brand-500/50 flex items-center justify-center text-brand-300 font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden lg:block font-medium">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                            </div>

                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl glass-panel py-1 shadow-lg focus:outline-none border border-white/10" style="display: none;">
                                <div class="px-4 py-2 border-b border-white/10">
                                    <p class="text-sm text-white truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('properties.mine') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-colors">Mes annonces</a>
                                
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-white/10">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Mobile menu button --}}
            <div class="-mr-2 flex md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none transition-colors">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" class="md:hidden glass-panel border-x-0 border-t-0 rounded-none border-b border-white/10 bg-black/60" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Accueil</a>
            <a href="{{ route('vente') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Vente</a>
            <a href="{{ route('location') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Location</a>
        </div>
        <div class="pt-4 pb-3 border-t border-white/10">
            @guest
                <div class="flex flex-col gap-2 px-4">
                    <a href="{{ route('login') }}" class="btn-secondary text-center w-full">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-primary text-center w-full">S'inscrire</a>
                </div>
            @endguest

            @auth
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-brand-500/20 border border-brand-500/50 flex items-center justify-center text-brand-300 font-bold text-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium leading-none text-gray-400 mt-1">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.properties.pending') }}" class="block px-3 py-2 rounded-md text-base font-medium text-amber-400 hover:text-amber-300 hover:bg-amber-500/10">Admin Panel</a>
                    @endif
                    <a href="{{ route('properties.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-brand-400 hover:text-brand-300 hover:bg-brand-500/10">+ Ajouter un bien</a>
                    <a href="{{ route('properties.mine') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5">Mes annonces</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10">
                            Déconnexion
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

{{-- ================= Contenu ================= --}}
<main class="flex-grow pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-8 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-8 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

{{-- ================= Footer ================= --}}
<footer class="border-t border-white/10 mt-auto bg-black/40 backdrop-blur-md">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex justify-center md:justify-start space-x-6 md:order-2">
                <a href="#" class="text-gray-400 hover:text-brand-400">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-brand-400">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} ImmoPlus. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
