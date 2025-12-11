@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Pendaftar Baru</p>
                <p class="text-3xl font-bold text-slate-800">{{ $pendingCount }}</p>
            </div>
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Peserta Aktif</p>
                <p class="text-3xl font-bold text-slate-800">{{ $activeCount }}</p>
            </div>
            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Kuota Tersedia</p>
                <p class="text-3xl font-bold text-slate-800">{{ $quotaAvailable }}</p>
            </div>
            <div class="bg-amber-100 text-amber-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Unit Penuh</p>
                <p class="text-3xl font-bold text-slate-800">{{ $fullUnits }}</p>
            </div>
            <div class="bg-rose-100 text-rose-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                    </path>
                </svg>
            </div>
        </div>
    </div>
    <!-- Main Section -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Applications Table -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Permohonan Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">Nama</th>
                            <th scope="col" class="px-6 py-3 font-medium">Universitas / Instansi</th>
                            <th scope="col" class="px-6 py-3 font-medium">Tanggal</th>
                            <th scope="col" class="px-6 py-3 font-medium">Status</th>
                            <th scope="col" class="px-6 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentApplications as $app)
                            <tr class="bg-white border-b border-slate-200 hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $app->user->name }}</td>
                                <td class="px-6 py-4">{{ $app->institution_name }}</td>
                                <td class="px-6 py-4">{{ $app->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($app->status == 'pending')
                                        <span
                                            class="px-2 py-1 text-xs font-medium text-amber-800 bg-amber-100 rounded-full">Menunggu</span>
                                    @elseif($app->status == 'approved')
                                        <span
                                            class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Diterima</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4"><a href="{{ route('admin.pendaftar') }}"
                                        class="font-semibold text-rose-600 hover:underline">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kuota per Unit Chart -->
        <div class="bg-white p-6 rounded-xl border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Kuota Peserta per Unit</h2>
            <div class="space-y-4">
                @forelse ($units as $unit)
                    @php
                        $filled = $unit->applications_count;
                        $percentage = $unit->quota > 0 ? ($filled / $unit->quota) * 100 : 0;
                        $colorClass = $percentage >= 100 ? 'bg-rose-600' : ($percentage >= 75 ? 'bg-amber-500' : 'bg-blue-600');
                    @endphp
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-slate-700">{{ $unit->name }}</span>
                            <span class="text-sm font-medium text-slate-700">{{ $filled }} / {{ $unit->quota }}</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2.5">
                            <div class="{{ $colorClass }} h-2.5 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center">Belum ada unit yang ditambahkan. Silakan tambahkan unit di
                        halaman Manajemen Kuota.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection