@extends('layouts.admin')

@section('header', 'Detail Surat')

@section('content')
    <div class="bg-white p-6 rounded-xl border border-slate-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Detail Surat</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.letters.download', $letter->id) }}"
                    class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                    <svg class="w-4 h-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('admin.letters.edit', $letter->id) }}"
                    class="inline-block px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 text-sm">
                    Edit
                </a>
                <a href="{{ route('admin.letters.index') }}"
                    class="inline-block px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 text-sm">
                    Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Letter Information -->
        <div class="mb-6 p-4 bg-slate-50 rounded-lg">
            <h3 class="text-lg font-semibold text-slate-800 mb-3">Informasi Surat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                <div>
                    <span class="font-medium text-slate-700">Template:</span>
                    <span class="text-slate-900">{{ $letter->template->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700">Nomor Surat:</span>
                    <span class="text-slate-900">{{ $letter->letter_number }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700">Kepada:</span>
                    <span class="text-slate-900">{{ $letter->recipient_name }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700">Tanggal Surat:</span>
                    <span class="text-slate-900">{{ $letter->letter_date->format('d F Y') }}</span>
                </div>
                @if ($letter->reference_number)
                    <div>
                        <span class="font-medium text-slate-700">Surat Saudara Nomor:</span>
                        <span class="text-slate-900">{{ $letter->reference_number }}</span>
                    </div>
                @endif
                @if ($letter->purpose)
                    <div class="md:col-span-2">
                        <span class="font-medium text-slate-700">Untuk Pelaksanaan:</span>
                        <span class="text-slate-900">{{ $letter->purpose }}</span>
                    </div>
                @endif
                <div>
                    <span class="font-medium text-slate-700">Penandatangan:</span>
                    <span class="text-slate-900">{{ $letter->signatory_name }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700">Dibuat Oleh:</span>
                    <span class="text-slate-900">{{ $letter->creator->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-slate-700">Dibuat Pada:</span>
                    <span class="text-slate-900">{{ $letter->created_at->format('d F Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Participants List -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-3">Daftar Peserta PKL ({{ $letter->participants->count() }}
                orang)</h3>
            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-sm">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-medium">No.</th>
                            <th scope="col" class="px-4 py-3 font-medium">Nama</th>
                            <th scope="col" class="px-4 py-3 font-medium">NPM/NIM</th>
                            <th scope="col" class="px-4 py-3 font-medium">Jurusan</th>
                            <th scope="col" class="px-4 py-3 font-medium">Unit</th>
                            <th scope="col" class="px-4 py-3 font-medium">Pembimbing</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($letter->participants as $index => $participant)
                            <tr class="bg-white border-b border-slate-200">
                                <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $participant->user->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $participant->nim ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $participant->major ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $participant->unit->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $participant->supervisor->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Letter Preview -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-3">Preview Surat</h3>
            <div class="p-6 border rounded-lg bg-white" style="max-height: 600px; overflow-y: auto;">
                {!! $letter->generated_content !!}
            </div>
        </div>
    </div>
@endsection