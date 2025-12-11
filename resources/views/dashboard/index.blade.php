@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-full md:w-1/3 h-64 rounded-lg overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop"
                        onerror="this.onerror=null;this.src='https://placehold.co/600x400/E53E3E/FFFFFF?text=Great+Place+for%0ADigital+Talent';"
                        class="absolute inset-0 w-full h-full object-cover" alt="Banner Program">
                </div>
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">Wujudkan Potensi Digital Anda Bersama Kami
                    </h1>
                    <p class="text-gray-600 mb-6">
                        PT. Telkom Indonesia membuka peluang bagi pelajar dan mahasiswa/i untuk ikut serta dalam
                        program Praktik Kerja Lapangan (PKL). Dapatkan pengalaman nyata mengerjakan proyek di
                        perusahaan telekomunikasi digital terbesar Indonesia.
                    </p>
                    <a href="{{ route('pendaftaran.create') }}"
                        class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 inline-block">Daftar
                        Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Our Programs Section -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Program Kami</h2>
            <p class="text-gray-600 mb-8 max-w-3xl">Melalui program Praktik Kerja Lapangan (PKL), Telkom memberikan
                kesempatan bagi pelajar dan mahasiswa/i Indonesia untuk terjun langsung ke *real project challenge*
                perusahaan.</p>
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Left Menu -->
                <div class="w-full md:w-1/4">
                    <div class="flex flex-col space-y-2">
                        <button
                            class="w-full text-left px-4 py-3 rounded-lg border-2 border-red-600 font-semibold text-red-600 bg-red-50 flex items-center space-x-3 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                            <span>Praktik Kerja Lapangan (PKL)</span>
                        </button>
                    </div>
                </div>
                <!-- Right Content -->
                <div class="w-full md:w-3/4 border rounded-lg p-6 bg-gray-50">
                    <!-- What We Need -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Apa yang kami butuhkan</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Siswa/i aktif SMK (minimal tahun ke-2) serta mahasiswa/i aktif S1 tingkat 3
                                    (min. semester 5) atau D3 tingkat 2 (min. semester 4).</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Berkomitmen penuh waktu (Senin-Jumat) sesuai durasi yang telah
                                    ditentukan.</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Mampu berkomunikasi dengan baik serta dapat bekerja secara mandiri maupun
                                    dalam tim.</span>
                            </li>
                        </ul>
                    </div>
                    <!-- What You Will Get -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Apa yang akan Anda dapatkan</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div><strong>Corporate Culture</strong>
                                    <p class="text-sm">Implementasi budaya kerja perusahaan yakni Amanah, Kompeten,
                                        Harmonis, Loyal, Adaptif, dan Kolaboratif (AKHLAK).</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div><strong>Real Project Challenge</strong>
                                    <p class="text-sm">Terjun langsung dalam *use case* nyata pada berbagai disiplin
                                        ilmu.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection