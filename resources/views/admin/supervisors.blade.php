@extends('layouts.admin')

@section('header', 'Manajemen Pembimbing')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-slate-800">Daftar Pembimbing PKL</h2>
            <div class="flex space-x-2">
                <input type="text" id="search-supervisor" placeholder="Cari pembimbing..."
                    class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                <button onclick="openModal('add-supervisor-modal')"
                    class="bg-rose-600 text-white px-4 py-2 rounded-lg hover:bg-rose-700 transition duration-150 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pembimbing
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Pembimbing</th>
                        <th scope="col" class="px-6 py-3">Jabatan</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($supervisors as $supervisor)
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $supervisor->name }}</td>
                            <td class="px-6 py-4">{{ $supervisor->position }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button class="p-2 bg-amber-100 text-amber-600 rounded-md hover:bg-amber-200 tooltip"
                                    onclick="editSupervisor('{{ $supervisor->id }}', '{{ $supervisor->name }}', '{{ $supervisor->position }}')"
                                    class="font-medium text-blue-600 hover:underline">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <button class="p-2 bg-rose-100 text-rose-600 rounded-md hover:bg-rose-200 tooltip"
                                    onclick="deleteSupervisor('{{ $supervisor->id }}', '{{ $supervisor->name }}')">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-slate-500">Belum ada data pembimbing.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $supervisors->links() }}
        </div>
    </div>

    <!-- Add Supervisor Modal -->
    <div id="add-supervisor-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('add-supervisor-modal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.supervisors.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-slate-900 mb-4">Tambah Pembimbing Baru</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Pembimbing</label>
                                <input type="text" name="name" required
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                                <input type="text" name="position" required
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-base font-medium text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" onclick="closeModal('add-supervisor-modal')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Supervisor Modal -->
    <div id="edit-supervisor-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('edit-supervisor-modal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="edit-supervisor-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-slate-900 mb-4">Edit Pembimbing</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Pembimbing</label>
                                <input type="text" name="name" id="edit-name" required
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                                <input type="text" name="position" id="edit-position" required
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Update</button>
                        <button type="button" onclick="closeModal('edit-supervisor-modal')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-supervisor-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('delete-supervisor-modal')"></div>
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
                            <h3 class="text-lg leading-6 font-medium text-slate-900">Hapus Pembimbing</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus pembimbing <span
                                        id="delete-supervisor-name" class="font-bold"></span>? Tindakan ini tidak dapat
                                    dibatalkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="delete-supervisor-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Hapus</button>
                    </form>
                    <button type="button" onclick="closeModal('delete-supervisor-modal')"
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

            function editSupervisor(id, name, position) {
                document.getElementById('edit-supervisor-form').action = `/admin/supervisors/${id}`;
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-position').value = position;
                openModal('edit-supervisor-modal');
            }

            function deleteSupervisor(id, name) {
                document.getElementById('delete-supervisor-form').action = `/admin/supervisors/${id}`;
                document.getElementById('delete-supervisor-name').textContent = name;
                openModal('delete-supervisor-modal');
            }

            // Search functionality
            document.getElementById('search-supervisor').addEventListener('input', function (e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const name = row.cells[0]?.textContent.toLowerCase() || '';
                    const position = row.cells[1]?.textContent.toLowerCase() || '';

                    if (name.includes(searchTerm) || position.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection