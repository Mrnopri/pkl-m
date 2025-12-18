@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-xl">
                
                {{-- LOGIKA UTAMA DIPINDAH KE SINI (BLADE) --}}
                <div class="text-center">

                    {{-- 1. STATUS: BELUM DAFTAR (KOSONG) --}}
                    @if (!$application)
                        <div class="flex justify-center mb-4">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Anda Belum Melakukan Pendaftaran</h2>
                        <p class="text-gray-600 max-w-lg mx-auto">Silakan menuju ke halaman Pendaftaran PKL untuk mengajukan permohonan Anda.</p>
                        <a href="{{ route('pendaftaran.create') }}" class="mt-6 inline-block px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                            Buka Formulir Pendaftaran
                        </a>

                    {{-- 2. STATUS: PENDING --}}
                    @elseif ($application->status == 'pending')
                        <div class="flex justify-center mb-4">
                            <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Sedang Ditinjau</h2>
                        <p class="text-gray-600 max-w-lg mx-auto">
                            Tim kami sedang melakukan verifikasi terhadap data dan berkas yang Anda kirim. Mohon tunggu informasi selanjutnya. Anda akan menerima notifikasi jika ada pembaruan.
                        </p>

                    {{-- 3. STATUS: APPROVED (DITERIMA) --}}
                    @elseif ($application->status == 'approved')
                        <div class="flex justify-center mb-4">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat, Pendaftaran Anda Diterima!</h2>
                        <p class="text-gray-600 max-w-lg mx-auto">
                            Anda telah diterima untuk program PKL di PT. Telkom Indonesia Witel Lampung. 
                            @if($application->unit)
                                Anda ditempatkan pada unit <strong>{{ $application->unit->name }}</strong>.
                            @endif
                            Surat tugas resmi dan informasi lebih lanjut akan dikirimkan ke email Anda.
                        </p>

                    {{-- 4. STATUS: REJECTED (DITOLAK) --}}
                    @elseif ($application->status == 'rejected')
                        <div class="flex justify-center mb-4">
                            <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Mohon Maaf, Pendaftaran Ditolak</h2>
                        <p class="text-gray-600 max-w-lg mx-auto">
                            Setelah melakukan peninjauan, kami belum dapat menerima pengajuan Anda saat ini.
                        </p>
                        <a href="{{ route('pendaftaran.create') }}" class="mt-6 inline-block px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                            Ajukan Kembali
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection