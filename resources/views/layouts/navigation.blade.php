<nav x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <svg class="w-9 h-9 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <span class="text-2xl font-bold text-gray-800">SIM PKL</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-10">
                <a href="{{ route('dashboard') }}"
                    class="text-gray-600 hover:text-red-600 font-medium pb-2 {{ request()->routeIs('dashboard') ? 'border-b-2 border-red-600 text-red-600' : '' }}">Beranda</a>
                <a href="{{ route('pendaftaran.create') }}"
                    class="text-gray-600 hover:text-red-600 font-medium pb-2 {{ request()->routeIs('pendaftaran.create') ? 'border-b-2 border-red-600 text-red-600' : '' }}">Pendaftaran
                    PKL</a>
                <a href="{{ route('status.index') }}"
                    class="text-gray-600 hover:text-red-600 font-medium pb-2 {{ request()->routeIs('status.index') ? 'border-b-2 border-red-600 text-red-600' : '' }}">Status
                    Pendaftaran</a>
                <a href="{{ route('tentang.index') }}"
                    class="text-gray-600 hover:text-red-600 font-medium pb-2 {{ request()->routeIs('tentang.index') ? 'border-b-2 border-red-600 text-red-600' : '' }}">Tentang
                    Kami</a>
            </nav>

            <!-- User Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <div
                        class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                    <div class="px-4 py-3 border-b">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                    <div class="border-t border-gray-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</a>
                    </form>
                </div>
            </div>

            <!-- Hamburger for Mobile -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}"
                class="block text-gray-600 hover:text-red-600 font-medium py-2 {{ request()->routeIs('dashboard') ? 'text-red-600' : '' }}">Beranda</a>
            <a href="{{ route('pendaftaran.create') }}"
                class="block text-gray-600 hover:text-red-600 font-medium py-2 {{ request()->routeIs('pendaftaran.create') ? 'text-red-600' : '' }}">Pendaftaran
                PKL</a>
            <a href="{{ route('status.index') }}"
                class="block text-gray-600 hover:text-red-600 font-medium py-2 {{ request()->routeIs('status.index') ? 'text-red-600' : '' }}">Status
                Pendaftaran</a>
            <a href="{{ route('tentang.index') }}"
                class="block text-gray-600 hover:text-red-600 font-medium py-2 {{ request()->routeIs('tentang.index') ? 'text-red-600' : '' }}">Tentang
                Kami</a>
        </div>
        <div class="pt-4 pb-4 border-t border-gray-200 px-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block text-gray-600 hover:text-red-600 py-2">Profil
                    Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block text-red-600 hover:text-red-800 py-2">Keluar</a>
                </form>
            </div>
        </div>
    </div>
</nav>