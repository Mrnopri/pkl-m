<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran PKL Telkom Witel Lampung</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-xl text-gray-800">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                SIM PKL
                            </a>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                        <a href="#" class="text-red-600 font-medium border-b-2 border-red-600 px-1 pt-1">Beranda</a>
                        <a href="{{ route('pendaftaran.create') }}"
                            class="text-gray-500 hover:text-gray-700 font-medium px-1 pt-1">Pendaftaran PKL</a>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="relative ml-3">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div
                                                class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold mr-2">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            <!-- {{ Auth::user()->name }} -->
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="px-4 py-2 border-b border-gray-100">
                                            <div class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</div>
                                            <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                        </div>
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profil Saya') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                                        this.closest('form').submit();">
                                                {{ __('Keluar') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @else
                            <div class="space-x-4">
                                <a href="{{ route('login') }}"
                                    class="text-gray-500 hover:text-gray-900 font-medium">Masuk</a>
                                <a href="{{ route('register') }}"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium">Daftar</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="relative h-64 md:h-auto">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80"
                                alt="Students working" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        <div class="p-8 md:p-12 flex flex-col justify-center">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                                Wujudkan Potensi Digital Anda Bersama Kami
                            </h1>
                            <p class="text-gray-600 mb-6">
                                PT. Telkom Indonesia membuka peluang bagi pelajar dan mahasiswa/i untuk ikut serta dalam
                                program Praktik Kerja Lapangan (PKL). Dapatkan pengalaman nyata mengerjakan proyek di
                                perusahaan telekomunikasi digital terbesar Indonesia.
                            </p>
                            <div>
                                <a href="{{ route('register') }}"
                                    class="inline-block bg-red-600 text-white px-6 py-3 rounded-md font-medium hover:bg-red-700 transition">
                                    Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Program Kami</h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Melalui program Praktik Kerja Lapangan (PKL), Telkom memberikan kesempatan bagi pelajar dan
                    mahasiswa/i Indonesia untuk terjun langsung ke *real project challenge* perusahaan.
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Sidebar Tabs -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-red-50 text-red-600 font-medium p-4 rounded-md border border-red-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                            Praktik Kerja Lapangan (PKL)
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="lg:col-span-3 bg-gray-50 p-8 rounded-xl border border-gray-100">
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Apa yang kami butuhkan</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-600">Siswa/i aktif SMK (minimal tahun ke-2) serta mahasiswa/i
                                        aktif S1 tingkat 3 (min. semester 5) atau D3 tingkat 2 (min. semester 4).</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-600">Berkomitmen penuh waktu (Senin-Jumat) sesuai durasi yang
                                        telah ditentukan.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-600">Mampu berkomunikasi dengan baik serta dapat bekerja
                                        secara mandiri maupun dalam tim.</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Apa yang akan Anda dapatkan</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium text-gray-900">Corporate Culture</span>
                                        <p class="text-gray-600 text-sm">Implementasi budaya kerja perusahaan yakni
                                            Amanah, Kompeten, Harmonis, Loyal, Adaptif, dan Kolaboratif (AKHLAK).</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium text-gray-900">Real Project Challenge</span>
                                        <p class="text-gray-600 text-sm">Terjun langsung dalam *use case* nyata pada
                                            berbagai disiplin ilmu.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>