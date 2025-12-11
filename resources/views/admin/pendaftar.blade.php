@extends('layouts.admin')

@section('header', 'Daftar Pendaftar')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Pendaftar Menunggu Persetujuan</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Institusi</th>
                        <th scope="col" class="px-6 py-3">Jurusan</th>
                        <th scope="col" class="px-6 py-3">Periode</th>
                        <th scope="col" class="px-6 py-3">File</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $app->user->name }}</td>
                            <td class="px-6 py-4">{{ $app->user->email }}</td>
                            <td class="px-6 py-4">{{ $app->institution_name }}</td>
                            <td class="px-6 py-4">{{ $app->major }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($app->start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($app->end_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ asset('storage/' . $app->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:underline flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="openApprovalModal({{ $app->id }}, '{{ $app->user->name }}')"
                                    class="font-medium text-green-600 hover:underline">Terima</button>
                                <button onclick="openRejectModal({{ $app->id }}, '{{ $app->user->name }}')"
                                    class="font-medium text-rose-600 hover:underline">Tolak</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-slate-500">Tidak ada pendaftar menunggu
                                persetujuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Approval Modal -->
    <div id="approval-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('approval-modal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="approval-form" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-slate-900 mb-4" id="modal-title">Terima & Tempatkan
                            Pendaftar</h3>
                        <div class="mb-4">
                            <p class="text-sm text-slate-600">Anda akan menerima pendaftar: <span id="applicant-name"
                                    class="font-bold text-slate-900"></span>. Silakan pilih unit penempatan yang tersedia.
                            </p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label for="unit_id" class="block text-sm font-medium text-slate-700 mb-2">Tempatkan di
                                    Unit</label>
                                <select name="unit_id" id="unit_id" required
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                    <option value="">-- Pilih Unit --</option>
                                    @foreach ($units as $unit)
                                        @php
                                            $filled = $unit->applications()->where('status', 'approved')->count();
                                            $remaining = $unit->quota - $filled;
                                            $isFull = $remaining <= 0;
                                        @endphp
                                        <option value="{{ $unit->id }}" {{ $isFull ? 'disabled' : '' }}>
                                            {{ $unit->name }} (Sisa: {{ $remaining }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="supervisor_id" class="block text-sm font-medium text-slate-700 mb-2">Pilih
                                    Pembimbing</label>
                                <select name="supervisor_id" id="supervisor_id" required
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                    <option value="">-- Pilih Pembimbing --</option>
                                    @foreach ($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">
                                            {{ $supervisor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">Konfirmasi
                            Penempatan</button>
                        <button type="button" onclick="closeModal('approval-modal')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('reject-modal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-slate-900">Tolak Pendaftar</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500">Apakah Anda yakin ingin menolak pendaftar <span
                                        id="reject-applicant-name" class="font-bold"></span>? Tindakan ini tidak dapat
                                    dibatalkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="reject-form" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Tolak</button>
                    </form>
                    <button type="button" onclick="closeModal('reject-modal')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            function openApprovalModal(appId, name) {
                document.getElementById('approval-form').action = `/admin/pendaftar/${appId}/approve`;
                document.getElementById('applicant-name').textContent = name;
                openModal('approval-modal');
            }

            function openRejectModal(appId, name) {
                document.getElementById('reject-form').action = `/admin/pendaftar/${appId}/reject`;
                document.getElementById('reject-applicant-name').textContent = name;
                openModal('reject-modal');
            }
        </script>
    @endpush
@endsection