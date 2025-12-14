@extends('layouts.admin')

@section('header', 'Surat yang Dibuat')

@section('content')
    <div class="bg-white p-6 rounded-xl border border-slate-200">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-slate-800 mb-2 md:mb-0">Daftar Surat</h2>
            <div class="flex space-x-2 w-full md:w-auto">
                <input type="text" id="search-letter" placeholder="Cari surat..."
                    class="flex-1 md:flex-none px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                <a href="{{ route('admin.letters.create') }}"
                    class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 text-sm flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Buat Surat</span>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">Nomor Surat</th>
                        <th scope="col" class="px-6 py-3 font-medium">Kepada</th>
                        <th scope="col" class="px-6 py-3 font-medium">Tanggal</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">Jumlah Peserta</th>
                        <th scope="col" class="px-6 py-3 font-medium">Dibuat Oleh</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($letters as $letter)
                        <tr class="bg-white border-b border-slate-200 hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $letter->letter_number }}</td>
                            <td class="px-6 py-4">{{ $letter->recipient_name }}</td>
                            <td class="px-6 py-4">{{ $letter->letter_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                    {{ $letter->participants->count() }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $letter->creator->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.letters.show', $letter->id) }}"
                                        class="inline-block p-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 tooltip"
                                        title="Lihat">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.letters.download', $letter->id) }}"
                                        class="inline-block p-2 bg-green-100 text-green-600 rounded-md hover:bg-green-200 tooltip"
                                        title="Download PDF">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.letters.edit', $letter->id) }}"
                                        class="inline-block p-2 bg-amber-100 text-amber-600 rounded-md hover:bg-amber-200 tooltip"
                                        title="Edit">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.letters.destroy', $letter->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block p-2 bg-rose-100 text-rose-600 rounded-md hover:bg-rose-200 tooltip"
                                            onclick="return confirm('Anda yakin ingin menghapus surat ini?')" title="Hapus">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada surat yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('search-letter').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const letterNumber = row.cells[0]?.textContent.toLowerCase() || '';
                const recipient = row.cells[1]?.textContent.toLowerCase() || '';

                if (letterNumber.includes(searchTerm) || recipient.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection