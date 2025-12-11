@extends('layouts.admin')

@section('header', 'Manajemen Peserta Aktif')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-slate-800">Daftar Peserta PKL Aktif</h2>
            <input type="text" id="search-participant" placeholder="Cari peserta..."
                class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3">Universitas / Instansi</th>
                        <th scope="col" class="px-6 py-3">Unit Penempatan</th>
                        <th scope="col" class="px-6 py-3">Pembimbing</th>
                        <th scope="col" class="px-6 py-3">Periode</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activeParticipants as $app)
                                    <tr class="bg-white border-b hover:bg-slate-50">
                                        <td class="px-6 py-4 font-medium text-slate-900">{{ $app->user->name }}</td>
                                        <td class="px-6 py-4">{{ $app->institution_name }}</td>
                                        <td class="px-6 py-4">
                                            @if ($app->unit)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $app->unit->name }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 text-xs">Belum ditempatkan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($app->supervisor)
                                                <span class="text-slate-700">{{ $app->supervisor->name }}</span>
                                            @else
                                                <span class="text-slate-400 text-xs">Belum ditentukan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($app->start_date)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($app->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button onclick="showDetailModal({{ json_encode([
                            'name' => $app->user->name,
                            'email' => $app->user->email,
                            'institution' => $app->institution_name,
                            'major' => $app->major,
                            'unit' => $app->unit?->name,
                            'supervisor_name' => $app->supervisor?->name,
                            'supervisor_position' => $app->supervisor?->position,
                            'start_date' => \Carbon\Carbon::parse($app->start_date)->format('d M Y'),
                            'end_date' => \Carbon\Carbon::parse($app->end_date)->format('d M Y'),
                        ]) }})" class="p-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-slate-500">Tidak ada peserta aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeDetailModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-6 pt-5 pb-4 sm:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-slate-900">Detail Peserta PKL</h3>
                        <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xl font-bold text-slate-900 mb-2" id="detail-name">-</h4>
                            <p class="text-sm text-slate-600 mb-1" id="detail-institution">-</p>
                            <p class="text-sm text-slate-600 mb-1" id="detail-major">-</p>
                            <p class="text-sm text-slate-600" id="detail-email">-</p>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Unit:</p>
                                <p class="text-base font-semibold text-slate-900" id="detail-unit">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-500">Periode:</p>
                                <p class="text-base text-slate-900" id="detail-period">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-500">Pembimbing:</p>
                                <p class="text-base font-semibold text-slate-900" id="detail-supervisor">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                    <button onclick="closeDetailModal()"
                        class="w-full inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:ml-3 sm:w-auto sm:text-sm">Tutup</button>
                    <button
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">Selesaikan
                        PKL</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showDetailModal(data) {
                document.getElementById('detail-name').textContent = data.name;
                document.getElementById('detail-institution').textContent = data.institution;
                document.getElementById('detail-major').textContent = data.major;
                document.getElementById('detail-email').textContent = data.email;
                document.getElementById('detail-unit').textContent = data.unit || 'Belum ditempatkan';
                document.getElementById('detail-period').textContent = data.start_date + ' - ' + data.end_date;

                if (data.supervisor_name) {
                    document.getElementById('detail-supervisor').textContent = data.supervisor_name + (data
                        .supervisor_position ? ' - ' + data.supervisor_position : '');
                } else {
                    document.getElementById('detail-supervisor').textContent = 'Belum ditentukan';
                }

                document.getElementById('detail-modal').classList.remove('hidden');
            }

            function closeDetailModal() {
                document.getElementById('detail-modal').classList.add('hidden');
            }

            // Search functionality
            document.getElementById('search-participant').addEventListener('input', function (e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const name = row.cells[0]?.textContent.toLowerCase() || '';
                    const institution = row.cells[1]?.textContent.toLowerCase() || '';
                    const unit = row.cells[2]?.textContent.toLowerCase() || '';
                    const supervisor = row.cells[3]?.textContent.toLowerCase() || '';

                    if (name.includes(searchTerm) || institution.includes(searchTerm) || unit.includes(searchTerm) ||
                        supervisor.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection