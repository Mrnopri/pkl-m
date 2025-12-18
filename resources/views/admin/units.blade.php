@extends('layouts.admin')

@section('header', 'Manajemen Kuota Unit')

@section('content')
    <div class="bg-white p-6 rounded-xl border border-slate-200">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-slate-800 mb-2 md:mb-0">Manajemen Kuota Unit</h2>
            <div class="flex space-x-2 w-full md:w-auto">
                <input type="text" id="search-unit" placeholder="Cari unit..."
                    class="flex-1 md:flex-none px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                <button onclick="openTambahUnitModal()"
                    class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 text-sm flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Tambah Unit</span>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">Nama Unit</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">Kuota Total</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">Terisi</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">Sisa</th>
                        <th scope="col" class="px-6 py-3 font-medium">Status</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($units as $unit)
                        @php
                            $filled = $unit->applications()->where('status', 'approved')->count();
                            $remaining = $unit->quota - $filled;
                        @endphp
                        <tr class="bg-white border-b border-slate-200 hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $unit->name }}</td>
                            <td class="px-6 py-4 text-center">{{ $unit->quota }}</td>
                            <td class="px-6 py-4 text-center">{{ $filled }}</td>
                            <td class="px-6 py-4 text-center">{{ $remaining }}</td>
                            <td class="px-6 py-4">
                                @if ($remaining > 0)
                                    <span
                                        class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Tersedia</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium text-rose-800 bg-rose-100 rounded-full">Penuh</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-1">
                                <button class="p-2 bg-amber-100 text-amber-600 rounded-md hover:bg-amber-200 tooltip"
                                    onclick="openEditUnitModal('{{ $unit->id }}', '{{ $unit->name }}', '{{ $unit->quota }}')">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 bg-rose-100 text-rose-600 rounded-md hover:bg-rose-200 tooltip"
                                        onclick="return confirm('Anda yakin ingin menghapus unit ini?')">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada unit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $units->links() }}
        </div>
    </div>

    <!-- Modal Tambah/Edit Unit -->
    <div id="unitModal"
        class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4 modal-backdrop opacity-0 transition-opacity duration-300">
        <div
            class="bg-white rounded-lg shadow-xl w-full max-w-md modal-content transform scale-95 transition-transform duration-300">
            <form id="unitForm" method="POST" action="{{ route('admin.units.store') }}">
                @csrf
                <div id="methodField"></div>
                <div class="p-6 border-b border-slate-200">
                    <h3 id="unitModalTitle" class="text-lg font-semibold text-slate-800">Tambah Unit Baru</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="unit_nama" class="block text-sm font-medium text-slate-700">Nama Unit</label>
                        <input type="text" id="unit_nama" name="name"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                            required>
                    </div>
                    <div>
                        <label for="unit_kuota" class="block text-sm font-medium text-slate-700">Jumlah Kuota</label>
                        <input type="number" id="unit_kuota" name="quota" min="0"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500"
                            required>
                    </div>
                </div>
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('unitModal')"
                        class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-md hover:bg-slate-50">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const content = modal.querySelector('.modal-content');
                if (content) content.classList.remove('scale-95');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('opacity-0');
            const content = modal.querySelector('.modal-content');
            if (content) content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function openTambahUnitModal() {
            document.getElementById('unitForm').reset();
            document.getElementById('unitForm').action = "{{ route('admin.units.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('unitModalTitle').textContent = 'Tambah Unit Baru';
            openModal('unitModal');
        }

        function openEditUnitModal(id, name, quota) {
            document.getElementById('unitForm').action = "/admin/units/" + id;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('unitModalTitle').textContent = 'Edit Kuota Unit';
            document.getElementById('unit_nama').value = name;
            document.getElementById('unit_kuota').value = quota;
            openModal('unitModal');
        }

        // Search functionality
        document.getElementById('search-unit').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.cells[0]?.textContent.toLowerCase() || '';

                if (name.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection