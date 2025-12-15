<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manajemen Data PKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f7f7f7;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50">

    <div class="flex h-screen bg-slate-50">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 hidden md:block bg-white border-r border-slate-200">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="h-16 flex items-center justify-center border-b border-slate-200">
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span class="text-xl font-bold text-slate-800">SIM PKL Telkom</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-6 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-slate-100 text-rose-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-rose-600' : 'text-slate-400' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.pendaftar') }}"
                        class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg {{ request()->routeIs('admin.pendaftar') ? 'bg-slate-100 text-rose-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.pendaftar') ? 'text-rose-600' : 'text-slate-400' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.226a3 3 0 00-4.682 2.72 9.094 9.094 0 003.741.479m-4.5-2.226a3 3 0 01-1.883-2.72 9.094 9.094 0 013.741-.479m5.411 2.684a3 3 0 01-1.883 2.72 9.094 9.094 0 013.741.479m-4.5-2.226a3 3 0 00-4.682-2.72 9.094 9.094 0 003.741.479M15 13.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Pendaftar
                    </a>
                    <a href="{{ route('admin.peserta') }}"
                        class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg {{ request()->routeIs('admin.peserta') ? 'bg-slate-100 text-rose-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.peserta') ? 'text-rose-600' : 'text-slate-400' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.182 14.818l4.95-4.95a2.25 2.25 0 000-3.182l-4.95-4.95a2.25 2.25 0 00-3.182 0l-4.95 4.95a2.25 2.25 0 000 3.182l4.95 4.95c.879.879 2.303.879 3.182 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.25 6.375a4.5 4.5 0 014.5-4.5h4.5a4.5 4.5 0 014.5 4.5v4.5a4.5 4.5 0 01-4.5 4.5h-4.5a4.5 4.5 0 01-4.5-4.5v-4.5z" />
                        </svg>
                        Peserta Aktif
                    </a>
                    <a href="{{ route('admin.units.index') }}"
                        class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg {{ request()->routeIs('admin.units.*') ? 'bg-slate-100 text-rose-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.units.*') ? 'text-rose-600' : 'text-slate-400' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.243 0 2.25 1.007 2.25 2.25v.008M4.5 21h15a2.25 2.25 0 002.25-2.25V8.25a2.25 2.25 0 00-2.25-2.25h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 21z" />
                        </svg>
                        Manajemen Kuota
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-slate-100 text-rose-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-rose-600' : 'text-slate-400' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        Manajemen Pengguna
                    </a>
                    <a href="{{ route('admin.supervisors.index') }}"
                        class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg {{ request()->routeIs('admin.supervisors.*') ? 'bg-slate-100 text-rose-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.supervisors.*') ? 'text-rose-600' : 'text-slate-400' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                        Manajemen Pembimbing
                    </a>
                    <a href="{{ route('admin.letters.index') }}"
                        class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg {{ request()->routeIs('admin.letters.*') || request()->routeIs('admin.letter-templates.*') ? 'bg-slate-100 text-rose-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.letters.*') || request()->routeIs('admin.letter-templates.*') ? 'text-rose-600' : 'text-slate-400' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Manajemen Surat
                    </a>
                </nav>

                <!-- Sidebar Footer -->
                <div class="px-4 py-4 mt-auto border-t border-slate-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-slate-100 rounded-lg cursor-pointer">
                            <svg class="w-5 h-5 mr-3 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Keluar
                        </a>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header id="main-header"
                class="h-16 flex items-center justify-between px-6 bg-white border-b border-slate-200">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Button (Mobile Only) -->
                    <button id="mobile-menu-button"
                        class="md:hidden text-slate-600 hover:text-slate-800 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold text-slate-800">@yield('header', 'Dasbor')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <div id="main-content" class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.querySelector('aside');

        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('inset-0');
                sidebar.classList.toggle('z-50');
                sidebar.classList.toggle('md:relative');
                sidebar.classList.toggle('md:translate-x-0');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnButton = mobileMenuButton.contains(event.target);

                if (!isClickInsideSidebar && !isClickOnButton && window.innerWidth < 768) {
                    if (!sidebar.classList.contains('hidden')) {
                        sidebar.classList.add('hidden');
                        sidebar.classList.remove('fixed', 'inset-0', 'z-50');
                    }
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>